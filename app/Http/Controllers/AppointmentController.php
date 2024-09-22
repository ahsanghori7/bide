<?php

namespace App\Http\Controllers;

use App\Http\Common\Constant;
use App\Http\Resources\AppointmentDetailsResource;
use App\Http\Resources\PatientDiabetesHistoryResource;
use App\Http\Resources\PatientMedicalHistoryResourceForAppointment;
use App\Http\Resources\PatientHistoryResource;
use App\Http\Resources\PatientReportsResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientSmbgResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VitalResource;
use App\Http\Resources\PatientPrescriptionResource;
use App\Http\Resources\PrescribedInsulinesResource;
use App\Http\Resources\PrescribedLabsResource;
use App\Http\Resources\PrescribedMedicinesResource;
use Illuminate\Http\Request;
use App\Models\DoctorQueue;
use App\Models\EducatorQueue;
use App\Http\Responses\ApiResponse;
use App\Models\Appointment;
use App\Models\PrescribedElement;
use App\Models\PatientVitals;
use App\Models\Patient;
use App\Models\User;
use App\Models\Prescription;
use App\Models\WaitingQueue;
use App\Services\DoctorService;
use App\Services\PatientService;
use App\Services\TokenService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    protected $tokenService;
    protected $patientService;
    protected $doctorService;

    public function __construct(
        TokenService $tokenService,
        PatientService $patientService,
        DoctorService $doctorService
    ) {
        $this->tokenService = $tokenService;
        $this->patientService = $patientService;
        $this->doctorService = $doctorService;
    }

    public function createAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:patient_info,id',
            'appt_date' => 'required',
        ], [
            'doctor_id.required' => trans('errors.doctor_id_required'),
            'doctor_id.exists' => trans('errors.invalid_doctor_id'),
            'patient_id.required' => trans('errors.patient_id_required'),
            'patient_id.exists' => trans('errors.patinet_id_invalid'),
            'appt_date.required' => trans('errors.appt_date_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Check if doctor has reached the daily limit
        $doctor = User::findOrFail($request->doctor_id);
        $dailyLimit = optional($doctor->config)->daily_limit ?? 0;
        $appointmentsCount = Appointment::where([
            'doctor_id' => $request->doctor_id,
            'date' => $request->appt_date,
        ])->where('status', '!=', Constant::APPOINTMENT_STATUS_CANCELLED)->count();

        if ($appointmentsCount >= $dailyLimit) {
            return response()->json(['error' => trans('errors.limit_exceed')], 422);
        }


        $already = Appointment::where(
            [
                'patient_id' => $request->patient_id,
                'date' => $request->appt_date,
            ]
        )->whereIn('status', [Constant::APPOINTMENT_STATUS_PENDING])
            ->whereIn('type', [Constant::APPOINTMENT_TYPE_INSTANT_VIDEO, Constant::APPOINTMENT_TYPE_INPERSON])->first();

        if ($already) {
            return response()->json(['error' => trans('errors.exists_appointment')], 200);
        }

        try {
            DB::beginTransaction();

            $type = $request->type;
            if ($request->has('waiting_queue_id')) {
                $waitingQueue = WaitingQueue::where('id', $request->waiting_queue_id)->first();
                $waitingQueue->update([
                    'status' => Constant::WAITING_QUEUE_STATUS_MOVED,
                ]);
                $type = $waitingQueue->type;
            }

            $appointment = Appointment::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'clinic_user_id' => $request->user()->clinic_user_id,
                'user_id' => 0,
                'date' => $request->appt_date,
                'action_by' => $request->user()->id,
                'time' => Carbon::now(),
                'type' => $type,
                'status' => Constant::APPOINTMENT_STATUS_PENDING,
            ]);

            $this->tokenService->getNextToken($request->doctor_id, $request->appt_date, $appointment->id);

            DoctorQueue::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'clinic_user_id' => $request->user()->clinic_user_id,
                'appointment_id' => $appointment->id,
                'status' => Constant::QUEUE_STATUS_INQUEUE,
            ]);

            if ($request->has('waiting_queue_id')) {
                WaitingQueue::where('id', $request->waiting_queue_id)->update([
                    'status' => Constant::WAITING_QUEUE_STATUS_MOVED,
                ]);
            }

            DB::commit();

            return ApiResponse::success(trans('success.appointment_created'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function createWatingList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patient_info,id'
        ], [
            'patient_id.required' => trans('errors.patient_id_required'),
            'patient_id.exists' => trans('errors.patinet_id_invalid'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            DB::beginTransaction();
            $existingAddedRecord = WaitingQueue::where('patient_id', $request->patient_id)
                ->where('status', 'added')
                ->whereDate('created_at', now()->toDateString())
                ->first();

            if ($existingAddedRecord) {
                return ApiResponse::error(trans('errors.patient_waiting'));
            }

            WaitingQueue::create([
                'patient_id' => $request->patient_id,
                'clinic_user_id' => $request->user()->clinic_user_id,
                'status' => 'added',
                'type' => $request->type,
            ]);


            DB::commit();

            return ApiResponse::success(trans('success.appointment_wait'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function deleteQueue($id)
    {

        try {
            $doctorQueue = DoctorQueue::findOrFail($id);
            $appointment_id = $doctorQueue->id;
            $doctorQueue->delete();
            Appointment::findOrFail($appointment_id)->delete();
            return ApiResponse::success(trans('success.appointment_deleted'));
        } catch (\Throwable $th) {
            // Handle exceptions
            throw $th; // Consider handling the exception appropriately, e.g., logging or returning an error response
        }
    }


    public function cancelAppointment(Request $request)
    {
        $decryptedAppointmentId = decrypt($request->appointment_id);
        $validator = Validator::make([
            'appointment_id' => $decryptedAppointmentId
        ], [
            'appointment_id' => 'required|exists:appointments,id'
        ], [
            'appointment_id.required' => trans("errors.appointment_id_required")
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }
        try {
            DB::beginTransaction();

            $userId = $request->user()->id;
            $appointment = Appointment::where('id', $decryptedAppointmentId)->first();

            if (
                $appointment->status == Constant::APPOINTMENT_STATUS_CANCELLED
            ) {
                return ApiResponse::error(trans('errors.appointment_cancelled_already'), 400);
            }

            DoctorQueue::where('appointment_id', $decryptedAppointmentId)->update(
                ['status' =>  Constant::APPOINTMENT_STATUS_CANCELLED]
            );

            $appointment->update([
                'status' => Constant::APPOINTMENT_STATUS_CANCELLED,
                'cancelled_by' => Constant::APPOINTMENT_STATUS_CANCELLED_BY_DOCTOR,
                'cancelled_time' => Carbon::now()->format('Y-m-d H:i:s'),
                'action_by' => $userId,
                'call_ended' => Carbon::now()->format('Y-m-d H:i:s'),
                'is_doctor_connected' => false,
                'agora_link' => null
            ]);

            User::where(['id' => $appointment->doctor_id])
                ->update(['in_call' => 0]);

            DB::commit();

            return ApiResponse::success(trans('success.cancel_appointment'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getAppointmentPatientInfo(Request $request)
    {
        $decryptedAppointmentId = decrypt($request->appointment_id);
        $apppointment = Appointment::with('doctor')
            ->where('id', $decryptedAppointmentId)
            ->has('doctor')
            ->first();

        $result = $this->patientService->patientForApp($apppointment->patient_id);
        $count = $this->doctorService->countPataintsInQueue($request);
        $patientVitals = PatientVitals::where('patient_id', $apppointment->patient_id)
            ->orderby('created_at', 'desc')
            ->first();

        $doctor = new UserResource($apppointment->doctor);

        $patientInfo = new PatientResource($result['patient_info']);
        $patientPersonalHistoryCollection = new PatientHistoryResource($result['patient_personal_history']);
        $patientMedicalHistoryCollection = new PatientMedicalHistoryResourceForAppointment(
            $result['patient_medical_history']
        );
        $patientDiabetesHistoryCollection = new PatientDiabetesHistoryResource(
            $result['patient_diabetes_history']
        );
        $patientReportollection = PatientReportsResource::collection($result['patient_reports']);
        $patientSmgbollection = PatientSmbgResource::collection($result['smgb']);
        $apppointment = new AppointmentDetailsResource($apppointment);
        $patientVitalsCollection = new VitalResource($patientVitals);

        $secondLastAppointment = Appointment::with('doctor')
            ->where('patient_id', $apppointment->patient_id)
            ->where('status', Constant::APPOINTMENT_STATUS_COMPLETED)
            ->where('id', '!=', $decryptedAppointmentId) // Exclude the current appointment
            ->orderBy('created_at', 'desc')
            ->first();

        $prescriptionMedicines = null;
        $prescriptionInsuline = null;
        $prescriptionLabs = null;
        $medicines = null;
        $insuline = null;
        $labs = null;
        $remarks = null;

        if ($secondLastAppointment) {
            $prescriptionMedicines = Prescription::where('appointment_id', $secondLastAppointment->id)
                ->with(['prescribedElements' => function ($query) {
                    $query->where('type', 'medicine');
                }])->first();

            $prescriptionInsuline = Prescription::where('appointment_id', $secondLastAppointment->id)
                ->with(['prescribedElements' => function ($query) {
                    $query->where('type', 'insulin');
                }])->first();

            $prescriptionLabs = Prescription::where('appointment_id', $secondLastAppointment->id)
                ->with(['prescribedElements' => function ($query) {
                    $query->where('type', 'lab');
                }])->first();

            $lastPrescription = Prescription::where('appointment_id', $secondLastAppointment->id)->first();

            if ($prescriptionMedicines && $prescriptionMedicines->prescribedElements->isNotEmpty()) {
                $medicines = PrescribedMedicinesResource::collection($prescriptionMedicines->prescribedElements);
            }

            if ($prescriptionInsuline && $prescriptionInsuline->prescribedElements->isNotEmpty()) {
                $insuline = PrescribedInsulinesResource::collection($prescriptionInsuline->prescribedElements);
            }

            if ($prescriptionLabs && $prescriptionLabs->prescribedElements->isNotEmpty()) {
                $labs = PrescribedLabsResource::collection($prescriptionLabs->prescribedElements);
            }

            $remarks = new PatientPrescriptionResource($lastPrescription);
        }

        return [
            'data' => [
                'patient_info' => $patientInfo,
                'patient_personal_history' => $patientPersonalHistoryCollection,
                'patient_medical_history' => $patientMedicalHistoryCollection,
                'patient_diabetes_history' => $patientDiabetesHistoryCollection,
                'patient_smgb' => $patientSmgbollection,
                'patient_reports' => $patientReportollection,
                'patient_vitals' => $patientVitalsCollection,
                'patient_count' => $count,
                'apppointment' => $apppointment,
                'doctor' => $doctor,
                'prescription' => [
                    'medicines' => $medicines,
                    'insuline' => $insuline,
                    'labs' => $labs,
                    'remarks' => $remarks
                ],
            ]
        ];
    }

    public function getAppointmentPatientInfoByMRNumber(Request $request)
    {
        $decryptedAppointmentId = decrypt($request->appointment_id);
        $appointment = Appointment::with('doctor')
            ->where('id', $decryptedAppointmentId)
            ->has('doctor')
            ->first();

        if (!$appointment) {
            return ApiResponse::error('Appointment not found');
        }
        $patientInfo = Patient::where('id', $appointment->patient_id)->first();

        $doctor = new DoctorResource($appointment->doctor);

        $patientInfoCollection  = new PatientResource($patientInfo);
        $appointments = new AppointmentDetailsResource($appointment);

        return [
            'data' => [
                'patient_info' => $patientInfoCollection,
                'apppointment' =>  $appointments,
                'doctor' => $doctor
            ]
        ];
    }



    public function appointmentComplete(Request $request)
    {
        $outerTransactionFailed = false;
        DB::beginTransaction();
        try {
            $decryptedAppointmentId = decrypt($request->appointment_id);
            $validatedData = Validator::make([
                'appointment_id' => $decryptedAppointmentId
            ], [
                'appointment_id' => 'required|exists:appointments,id'
            ], [
                'appointment_id.required' => trans("errors.appointment_id_required")
            ]);

            if ($validatedData->fails()) {
                return ApiResponse::error($validatedData->errors()->first());
            }

            $appointment = Appointment::where([
                'id' => $decryptedAppointmentId,
                'status' => Constant::APPOINTMENT_STATUS_COMPLETED
            ])->first();
            if ($appointment) {
                return ApiResponse::error(trans('errors.appointment_complete_already'));
            }
            $request['status'] = true;
            $requestData = $request->all();
            $requestData['appointment_id'] = $decryptedAppointmentId;
            $prescription = Prescription::create($requestData);

            if ($request->medicines) {
                foreach ($request->medicines as $medicineData) {
                    try {
                        if ($medicineData['is_after_meal'] == "Null") {
                            $is_after_meal = false;
                            $is_before_meal = false;
                        } elseif ($medicineData['is_after_meal'] == 1) {
                            $is_after_meal = true;
                            $is_before_meal = false;
                        } elseif ($medicineData['is_after_meal'] == 0) {
                            $is_after_meal = false;
                            $is_before_meal = true;
                        }
                        PrescribedElement::create([
                            'prescription_id' => $prescription->id,
                            'type' => 'medicine',
                            'generic_id' => $medicineData['generic'] ?? null,
                            'type_id' => $medicineData['unit'],
                            'route_id' => $medicineData['route'] ?? null,
                            'item_strength_id' => $medicineData['strength'] ?? null,
                            'is_after_meal' => $is_after_meal,
                            'is_before_meal' => $is_before_meal,
                            'morning' => $medicineData['morning'],
                            'noon' => $medicineData['afternoon'],
                            'evening' => $medicineData['evening'],
                            'night' => $medicineData['night'],
                            'number_of_days' => $medicineData['number_of_days'],
                            'prescription_element_id' => $medicineData['prescription_element_id']
                        ]);
                    } catch (\Throwable $e) {
                        $outerTransactionFailed = true;
                        DB::rollBack();
                        return ApiResponse::error($e->getMessage());
                    }
                }
            }

            if ($request->insulines) {
                foreach ($request->insulines as $insulines) {
                    try {
                        if ($insulines['is_after_meal'] == "Null") {
                            $is_after_meal = false;
                            $is_before_meal = false;
                        } elseif ($insulines['is_after_meal'] == 1) {
                            $is_after_meal = true;
                            $is_before_meal = false;
                        } elseif ($insulines['is_after_meal'] == 0) {
                            $is_after_meal = false;
                            $is_before_meal = true;
                        }
                        PrescribedElement::create([
                            'prescription_id' => $prescription->id,
                            'type' => 'insulin',
                            'is_after_meal' => $is_after_meal,
                            'is_before_meal' => $is_before_meal,
                            'morning' => $insulines['morning'],
                            'noon' => $insulines['afternoon'],
                            'evening' => $insulines['evening'],
                            'night' => $insulines['night'],
                            'unit' => $insulines['unit'],
                            'number_of_days' => $insulines['number_of_days'],
                            'prescription_element_id' => $insulines['prescription_element_id']
                        ]);
                    } catch (\Throwable $e) {
                        $outerTransactionFailed = true;
                        DB::rollBack();
                        return ApiResponse::error($e->getMessage());
                    }
                }
            }

            if ($request->labs) {
                foreach ($request->labs as $lab) {
                    try {
                        PrescribedElement::create([
                            'prescription_id' => $prescription->id,
                            'type' => 'lab',
                            'prescription_element_id' => $lab['prescription_element_id'],
                        ]);
                    } catch (\Throwable $e) {
                        $outerTransactionFailed = true;
                        DB::rollBack();
                        return ApiResponse::error($e->getMessage());
                    }
                }
            }

            if ($request->vitals) {
                $vitals = (object) $request->vitals;
                PatientVitals::where(['patient_id' => $vitals->patient_id, 'id' =>  $vitals->id])->update([
                    "blood_pressure_diastolic" => $vitals->blood_pressure_diastolic,
                    "blood_pressure_systolic" => $vitals->blood_pressure_systolic,
                    "bmi" => $vitals->bmi,
                    "glucometer_result" => $vitals->glucometer_result,
                    "heart_rate" => $vitals->heart_rate,
                    "height" => $vitals->height,
                    "temperature" => $vitals->temperature,
                    "weight" => $vitals->weight,
                ]);
            }

            $appointment = Appointment::findOrFail($decryptedAppointmentId);
            $appointment->call_ended = Carbon::now();
            $appointment->agora_link = null;
            $appointment->is_patient_connected = 0;
            $appointment->is_doctor_connected = 0;
            $appointment->follow_up_date = $request->follow_up_date;
            $appointment->save();

            $doctorQueueData = DoctorQueue::where('appointment_id', $decryptedAppointmentId)->first();

            EducatorQueue::create([
                'patient_id' => $doctorQueueData->patient_id,
                'doctor_id' => $doctorQueueData->doctor_id,
                'clinic_user_id' => $doctorQueueData->clinic_user_id,
                'appointment_id' => $doctorQueueData->appointment_id,
            ]);

            $doctorQueueData->update(['status' =>  Constant::QUEUE_STATUS_COMPLETED]);


            $doctorId = $appointment->doctor_id;
            User::where('id', $doctorId)->update(['in_call' => 0]);
            if (!$outerTransactionFailed) {
                DB::commit();
                return ApiResponse::success();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function disconnectDoctor(Request $request)
    {
        try {
            $decryptedAppointmentId = decrypt($request->appointment_id);
            $validatedData = Validator::make([
                'appointment_id' => $decryptedAppointmentId
            ], [
                'appointment_id' => 'required|exists:appointments,id'
            ], [
                'appointment_id.required' => trans("errors.appointment_id_required")
            ]);

            if ($validatedData->fails()) {
                return ApiResponse::error($validatedData->errors()->first());
            }

            Appointment::where('id', $decryptedAppointmentId)->update(['is_doctor_connected' => false]);

            return ApiResponse::success(trans('success.disconnected'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
