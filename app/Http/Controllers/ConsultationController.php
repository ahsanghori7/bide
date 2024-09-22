<?php

namespace App\Http\Controllers;

use App\Http\Resources\LastAssessmentResource;
use App\Models\EducationalAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Responses\ApiResponse;
use App\Models\{Appointment, DietaryAssessment, DoctorQueue, EducatorQueue, PatientVitals, Prescription};
use App\Models\MealEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Common\agora\RtmTokenBuilder;
use App\Http\Common\Constant;
use App\Http\Common\agora\RtcTokenBuilder;
use App\Http\Resources\AssessmentQuestionResource;
use App\Http\Resources\PatientPrescriptionResource;
use App\Models\EducationalAssessmentQuestion;
use App\Models\User;
use App\Services\PatientService;
use PDF;

class ConsultationController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }


    public function showAssessment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|integer'
        ], [
            'patient_id.required' => trans('errors.patient_id_required')
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $lastApp = Appointment::where([
            'patient_id' => $request->patient_id,
            'status' => Constant::APPOINTMENT_STATUS_COMPLETED
        ])->first();

        if ($lastApp) {
            $lastAssessment = EducationalAssessment::with('questions')
                ->where(['patient_id' => $request->patient_id, 'appointment_id' => $lastApp->id])
                ->get();

            if ($lastAssessment->isEmpty()) {
                return ApiResponse::error(trans('errors.assessment_not_found'), 404);
            }
            return LastAssessmentResource::collection($lastAssessment);
        } else {
            return ApiResponse::error(trans('errors.appointment_not_found'), 404);
        }
    }

    public function patinetAssessments(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|integer',
            'date' => 'required'
        ], [
            'patient_id.required' => trans('errors.patient_id_required'),
            'date.required' => trans('errors.assessment_date_required')
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $appointments = Appointment::where([
            'patient_id' => $request->patient_id,
            'status' => Constant::APPOINTMENT_STATUS_COMPLETED,
            'date' => $request->date,
        ])->pluck('id');

        if ($appointments->isNotEmpty()) {
            $assessments = EducationalAssessment::with('questions')
                ->where('patient_id', $request->patient_id)
                ->whereIn('appointment_id', $appointments)
                ->get();

            if ($assessments->isEmpty()) {
                return ApiResponse::error(trans('errors.assessment_not_found'), 404);
            }
            return LastAssessmentResource::collection($assessments);
        } else {
            return ApiResponse::error(trans('errors.appointment_not_found'), 404);
        }
    }

    public function saveEduAssessment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,id',
            'question.*.question_id' => 'required|exists:educational_assessment_questions,id',
            'question.*.answer' => 'required',
            'assessment_date' => 'required|date'
        ], [
            'appointment_id.required' => trans('errors.appointment_id_required'),
            'appointment_id.exists' => trans('errors.invalid_appointment_id'),
            'question.*.question_id.required' => trans('errors.question_id_required'),
            'question.*.question_id.exists' => trans('errors.invalid_question_id'),
            'question.*.answer.required' => trans('errors.answer_required'),
            'assessment_date.required' => trans('errors.psu'),
            'assessment_date.date' => trans('errors.assessment_date_date'),
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        $appointment = Appointment::findOrFail($request->appointment_id);
        $patientId = $appointment->patient_id;

        try {
            DB::beginTransaction();
            foreach ($request->question as $question) {
                $elements = $question['elements'] ?? null;

                if ($elements) {
                    foreach ($elements as $element) {
                        $elementId = $element['element_id'] ?? null;
                        $elementValue = $element['element_value'] ?? null;

                        $existingAssessment = EducationalAssessment::where('patient_id', $patientId)
                            ->where('appointment_id', $request->appointment_id)
                            ->where('question_id', $question['question_id'])
                            ->where('element_id', $elementId)
                            ->first();

                        if ($existingAssessment) {
                            $existingAssessment->update([
                                'answer' => $question['answer'],
                                'element_value' => $elementValue,
                                'assessment_date' => $request->assessment_date
                            ]);
                        } else {
                            EducationalAssessment::create([
                                'patient_id' => $patientId,
                                'answer' => $question['answer'],
                                'appointment_id' => $request->appointment_id,
                                'question_id' => $question['question_id'],
                                'element_id' => $elementId,
                                'element_value' => $elementValue,
                                'assessment_date' => $request->assessment_date
                            ]);
                        }
                    }
                } else {
                    $existingAssessment = EducationalAssessment::where('patient_id', $patientId)
                        ->where('appointment_id', $request->appointment_id)
                        ->where('question_id', $question['question_id'])
                        ->whereNull('element_id')
                        ->first();

                    if ($existingAssessment) {
                        $existingAssessment->update([
                            'answer' => $question['answer'],
                            'assessment_date' => $request->assessment_date
                        ]);
                    } else {
                        EducationalAssessment::create([
                            'patient_id' => $patientId,
                            'answer' => $question['answer'],
                            'appointment_id' => $request->appointment_id,
                            'question_id' => $question['question_id'],
                            'assessment_date' => $request->assessment_date
                        ]);
                    }
                }
            }
            EducatorQueue::where('appointment_id', $request->appointment_id)->update([
                'status' => Constant::EDUCATOR_QUEUE_STATUS_COMPLETE
            ]);
            Appointment::where('id', $request->appointment_id)->update([
                'status' => Constant::APPOINTMENT_STATUS_COMPLETED
            ]);
            DB::commit();
            return ApiResponse::success(trans('success.assessment_saved'), 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }



    public function saveDietaryAssessment(Request $request)
    {
        try {
            DB::beginTransaction();
            Validator::extend('numeric_when_not_empty', function ($attribute, $value, $parameters, $validator) {
                if (empty($value)) {
                    return true;
                }
                return is_numeric($value);
            });
            $validator = Validator::make($request->all(), [
                'appointment_id' => ['exists:appointments,id'],
                'fats_intake' => ['numeric_when_not_empty'],
                'calories_intake' => ['numeric_when_not_empty'],
                'calories_required' => ['numeric_when_not_empty'],
                'calories_advised' => ['numeric_when_not_empty'],
                'visit_no' => ['numeric_when_not_empty'],
                'protein_intake' => ['numeric_when_not_empty'],
                'sodium_intake' => ['numeric_when_not_empty'],
                'age' => ['required', 'numeric_when_not_empty'],
                'cereal_misc' =>  ['numeric_when_not_empty'],
                'fats_misc' =>  ['numeric_when_not_empty'],
                'calories_misc' =>  ['numeric_when_not_empty'],
                'meal_entries' => ['array'],
                'meal_entries.*.meal_time_id' => ['numeric_when_not_empty'],
                'meal_entries.*.cereal' => ['numeric_when_not_empty'],
                'meal_entries.*.vegetable' => ['numeric_when_not_empty'],
                'meal_entries.*.meat' => ['numeric_when_not_empty'],
                'meal_entries.*.milk' => ['nullable', 'numeric_when_not_empty'],
                'meal_entries.*.fruits' => ['numeric_when_not_empty'],
                'meal_entries.*.fats' => ['nullable', 'numeric_when_not_empty'],
                'meal_entries.*.calories' => ['nullable', 'numeric_when_not_empty'],
                'meal_entries.*.carbo' => ['nullable', 'numeric_when_not_empty'],
                'meal_entries.*.protein' => ['nullable', 'numeric_when_not_empty'],

            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $app = Appointment::where('id', $request->appointment_id)->first();
            if (!$app) {
                return ApiResponse::error(trans('errors.appointment_not_found'));
            }
            $ibw = $this->patientService->ibwCalculate($app->patient_id, $app->date);
            $bmi = $this->patientService->getBmi($app->patient_id, $app->date);
            $bee = $this->patientService->beeCalculate($app->patient_id, $app->date);
            // Create DietaryAssessment
            $dietaryAssessment = DietaryAssessment::updateOrCreate(
                ['appointment_id' => $request->appointment_id],
                [
                    'appointment_id' => $request->appointment_id,
                    'fats_intake' => $request->fats_intake,
                    'calories_intake' => $request->calories_intake,
                    'calories_required' => $request->calories_required,
                    'calories_advised' => $request->calories_advised,
                    'activity_factor' => $request->activity_factor,
                    'injury_factor' => $request->injury_factor,
                    'compliance' => $request->compliance,
                    'visit_no' => $request->visit_no,
                    'age' => $request->age,
                    'protein_intake' => $request->protein_intake,
                    'sodium_intake' => $request->sodium_intake,
                    'remarks' => $request->remarks,
                    'ibw' => $ibw,
                    'bmi' => $bmi,
                    'bee' => $bee,
                ]
            );

            $dietaryAssessmentId = $dietaryAssessment->id;

            foreach ($request->meal_entries as $entry) {
                $attributes = [
                    'meal_time_id' => $entry['meal_time_id'],
                    'dietary_assessment_id' => $dietaryAssessmentId,
                ];
                $values = [
                    'cereal' => $entry['cereal'] ?? null,
                    'vegetable' => $entry['vegetable'] ?? null,
                    'meat' => $entry['meat'] ?? null,
                    'milk' => $entry['milk'] ?? null,
                    'fruits' => $entry['fruits'] ?? null,
                    'fats' => $entry['fats'] ?? null,
                    'calories' => $entry['calories'] ?? null,
                    'carbo' => $entry['carbo'] ?? null,
                    'protein' => $entry['protein'] ?? null,
                    'cereal_misc' => $entry['cereal_misc'] ?? null,
                    'fats_misc' => $entry['fats_misc'] ?? null,
                    'calories_misc' => $entry['calories_misc'] ?? null,
                ];

                MealEntry::updateOrCreate($attributes, $values);
            }

            EducatorQueue::where('appointment_id', $request->appointment_id)->update([
                'status' => Constant::EDUCATOR_QUEUE_STATUS_COMPLETE
            ]);
            Appointment::where('id', $request->appointment_id)->update([
                'status' => Constant::APPOINTMENT_STATUS_COMPLETED
            ]);
            DB::commit();
            return ApiResponse::success(trans('success.dietary_saved'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    public function getDietaryAssessment(Request $request)
    {
        $dietaryAssessment = DietaryAssessment::with('mealEntries.mealTime');
        $download = $request->has('download') && $request->input('download') === 'true';
        if ($request && $request->patient_id) {
            $appointment =  Appointment::where([
                'patient_id' => $request->patient_id,
                'date' => $request->appointment_date
            ])->where('status', '!=', Constant::APPOINTMENT_STATUS_CANCELLED)->first();

            if ($appointment) {
                $dietaryAssessment = $dietaryAssessment->where('appointment_id', $appointment->id)->first();

                $vitals = PatientVitals::where('patient_id', $request->patient_id)
                    ->whereDate('created_at', $request->appointment_date)->first();

                if ($vitals && $dietaryAssessment) {
                    $dietaryAssessment->weight = $vitals->weight;
                    $dietaryAssessment->height = ($vitals->height * 100);
                } else {
                    $result = PatientVitals::select('weight', 'height')->where('patient_id', $request->patient_id)
                        ->orderby('created_at', 'desc')->first();
                    $dietaryAssessment = new DietaryAssessment();
                    $dietaryAssessment->weight = $result->weight;
                    $dietaryAssessment->height = ($result->height * 100);
                }

                $dietaryAssessment->ibw = $this->patientService->ibwCalculate(
                    $appointment->patient_id,
                    $request->appointment_date
                );
                $dietaryAssessment->bmi = $this->patientService->getBmi(
                    $appointment->patient_id,
                    $request->appointment_date
                );
                $dietaryAssessment->bee = $this->patientService->beeCalculate(
                    $appointment->patient_id,
                    $request->appointment_date
                );
                if ($download) {
                    $result = $this->patientService->getPatient($request->patient_id);
                    $patientInfo = $result['patient_info'];
                    $customPaper = array(0, 0, 1500, 1300);
                    $pdf = PDF::setPaper($customPaper, 'landscape')
                        ->loadView(
                            'download.dietary_assessment',
                            compact('dietaryAssessment', 'patientInfo')
                        );
                    return $pdf->download('dietary_assessment.pdf');
                }


                return ApiResponse::success($dietaryAssessment, 200);
            } else {
                return ApiResponse::error(trans('errors.assessment_not_found'));
            }
        }
    }


    public function startAssessment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'queue_id' => 'required|exists:educator_queues,id',

        ], [
            'queue_id.required' => trans('errors.queue_id_required'),
            'queue_id.exists' => trans('errors.invalid_queue_id'),
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }
        try {
            $queueDetails = EducatorQueue::findOrFail($request->queue_id);
            $queueDetails->status = Constant::EDUCATOR_QUEUE_STATUS_START;
            $queueDetails->save();
            return ApiResponse::success([
                'patient_id' => $queueDetails->patient_id,
                'appointment_id' => $queueDetails->appointment_id
            ]);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 500);
        }
    }

    public function startConsultation(Request $request)
    {
        $decryptedAppointmentId = decrypt($request->appointment_id);
        $validator = Validator::make(['appointment_id' => $decryptedAppointmentId], [
            'appointment_id' => 'required|exists:appointments,id',

        ], [
            'appointment_id.required' => trans('errors.appointment_id_required'),
            'appointment_id.exists' => trans('errors.invalid_appointment_id'),
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors()->first(), 422);
        }

        try {
            DB::beginTransaction();

            $appointment =  Appointment::where(['id' => $decryptedAppointmentId])->first();

            if ($appointment->call_started === null) {
                $appointment->call_started = now();
            }
            $appointment->status = constant::APPOINTMENT_STATUS_PROGRESS;
            $appointment->is_doctor_connected = 1;
            $appointment->save();

            $doctorQueue = DoctorQueue::where(
                ['appointment_id' => $decryptedAppointmentId]
            )->first();
            $doctorQueue->update(['status' => constant::QUEUE_STATUS_PROGRESS]);

            User::where(['id' => $doctorQueue->doctor_id])
                ->update(['in_call' => true]);

            $userId = $request->user() ? $request->user()->id : $appointment->patient_id;
            $token = $this->rtmTokenGenrator($userId);
            DB::commit();
            return ApiResponse::success(['token' => $token]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function rtmTokenGenrator($request)
    {
        try {
            $rtmBuilder = new RtmTokenBuilder();
            $appID = env('AGORA_APP_ID');
            $appCertificate = env('AGORA_APP_CERTIFICATE');
            $uidStr = (string) $request;
            $expireTimeInSeconds = 86400;

            $currentTimestamp = time();
            $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

            return $rtmBuilder::buildToken($appID, $appCertificate, $uidStr, $privilegeExpiredTs);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function rtmToken(Request $request)
    {
        $decryptedAppointmentId = decrypt($request->appointment_id);
        $getAppointment = Appointment::where('id', $decryptedAppointmentId)->first();
        if ($getAppointment && $getAppointment->agora_link) {
            return ApiResponse::success([
                'agora_token' => $getAppointment->agora_link,
                'channel_name' => env("AGORA_CHANNEL_NAME") . $getAppointment->id
            ]);
        }
    }

    public function generateAgoraLink(Request $request)
    {
        try {
            if (!$request->appointment_id) {
                return ApiResponse::error(trans('errors.appointment_id_required'), 422);
            }
            $decryptedAppointmentId = decrypt($request->appointment_id);
            $getAppointment = Appointment::find($decryptedAppointmentId);
            if (!$getAppointment) {
                return ApiResponse::error(trans("errors.appointment_not_found"), 404);
            }
            if ($getAppointment->status == Constant::APPOINTMENT_STATUS_CANCELLED) {
                return ApiResponse::error("Appointment " . $getAppointment->cancelled_by, 404);
            }
            if ($getAppointment->status == Constant::APPOINTMENT_STATUS_COMPLETED) {
                return ApiResponse::error(trans("errors.appointment_complete_already"), 404);
            }

            if (isset($request->user_id) && $getAppointment->doctor_id == $request->user_id) {
                if (!$getAppointment->call_started) {
                    $getAppointment->update(['is_doctor_connected' => 1, 'call_started' => Carbon::now()]);
                }
            }

            if ($getAppointment->agora_link) {
                return ApiResponse::success([
                    'agora_token' => $getAppointment->agora_link,
                    'channel_name' => env("AGORA_CHANNEL_NAME") . $getAppointment->id,
                    'remaining_time' => $this->patientService->calculateRemainingTime(
                        $getAppointment->id,
                        Constant::APPOINTMENT_INSTANT_TIME,
                        $getAppointment->doctor_id
                    ),
                    'call_ended' => $getAppointment->call_ended
                ]);
            }
            $agoraDetails = $this->token($decryptedAppointmentId);
            $getAppointment->update(['agora_link' => $agoraDetails['agora_token']]);

            return ApiResponse::success([
                'agora_token' => $agoraDetails['agora_token'],
                'channel_name' => $agoraDetails['channnel_name'],
                'remaining_time' => $this->patientService->calculateRemainingTime(
                    $getAppointment->id,
                    Constant::APPOINTMENT_INSTANT_TIME,
                    $getAppointment->doctor_id
                ),
                'call_ended' => $getAppointment->call_ended
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function token($getRoom)
    {
        $channelName = env("AGORA_CHANNEL_NAME") . $getRoom;
        $channelToken = $this->processToken($channelName);
        return [
            'agora_token' => $channelToken,
            'channnel_name' => $channelName
        ];
    }

    private function processToken($channelName)
    {
        $rtcBuilder = new RtcTokenBuilder();
        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $uidStr = "0";
        $role = $rtcBuilder::RolePublisher;
        $expireTimeInSeconds = 86400; // expires after a day

        // $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = $rtcBuilder::buildTokenWithUserAccount(
            $appID,
            $appCertificate,
            $channelName,
            $uidStr,
            $role,
            $privilegeExpiredTs
        );
        return $token;
    }


    public function getPrescription(Request $request)
    {
        $download = $request->has('download') && $request->input('download') === 'true';

        try {
            $prescription = Prescription::with('prescribedElements');

            if (!$request->appointment_id && !$request->patient_id && !$request->date) {
                return ApiResponse::error(trans('errors.appointment_not_found'));
            }

            if ($request->appointment_id) {
                $prescription = $prescription->where('appointment_id', $request->appointment_id);
            }

            if ($request->patient_id && $request->date) {
                $app = Appointment::whereDate('date', $request->date)
                    ->where(
                        ['patient_id' => $request->patient_id, 'status' => Constant::APPOINTMENT_STATUS_COMPLETED]
                    )->first();
                if ($app) {
                    $prescription->where('appointment_id', $app->id);
                } else {
                    return ApiResponse::error(trans('errors.appointment_not_found'));
                }
            }
            $prescription = $prescription->get();
            if ($download) {
                if ($request->appointment_id) {
                    $app = Appointment::where('id', $request->appointment_id)->first();
                }
                $result = $this->patientService->getPatient($app->patient_id);
                $patientInfo = $result['patient_info'];
                $customPaper = array(0, 0, 1500, 1300);
                $pdf = PDF::setPaper($customPaper, 'landscape')
                    ->loadView(
                        'download.prescription',
                        compact('patientInfo', 'prescription')
                    );
                return $pdf->download('prescription.pdf');
            } else {
                return PatientPrescriptionResource::collection($prescription);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }



    public function startConsultaion(Request $request)
    {
        try {
            $decryptedAppointmentId = decrypt($request->appointment_id);
            $validator = Validator::make(['appointment_id' => $decryptedAppointmentId], [
                'appointment_id' => 'required|exists:appointments,id'

            ], [
                'appointment_id.required' => trans('errors.appointment_id_required'),
                'appointment_id.exists' => trans('errors.invalid_appointment_id'),
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $doctorQueue = DoctorQueue::where(
                [
                    'appointment_id' => $decryptedAppointmentId
                ]
            )->first();
            $appointment = Appointment::where(
                ['id' => $decryptedAppointmentId]
            )->first();
            if ($doctorQueue && $appointment) {
                if ($appointment->is_doctor_connected == 0 && $appointment->call_started == null) {
                    $message  = trans("success.wait");
                } elseif ($appointment->is_doctor_connected == 0 && $appointment->call_started !== null) {
                    $message = trans("success.re_join");
                } elseif ($appointment->status == Constant::APPOINTMENT_STATUS_CANCELLED) {
                    $message  = trans("success.cancel");
                } elseif ($appointment->is_doctor_connected == 1) {
                    $message  = trans("success.connected");
                }
                $data = [
                    'redirect' => $appointment->status == Constant::APPOINTMENT_STATUS_PROGRESS ? true : false,
                    'appointment_id' => $request->appointment_id,
                    'is_waiting' => $appointment->status == Constant::APPOINTMENT_STATUS_PROGRESS ? false : true,
                    'waiting_time' => $this->calculateWaitingTime($appointment->id, $appointment->doctor_id),
                    'existing_appointments' => $appointment,
                    'is_doctor_connected' => $appointment->is_doctor_connected,
                    'remaining_time' => $this->patientService->calculateRemainingTime(
                        $decryptedAppointmentId,
                        Constant::APPOINTMENT_INSTANT_TIME,
                        $appointment->doctor_id
                    ),
                    'is_canceled' => $appointment->status == Constant::APPOINTMENT_STATUS_CANCELLED ? true : false,
                    'message' => $message,
                    'status' => $appointment->status,
                    'call_ended' => $appointment->call_ended,
                ];
                return ApiResponse::success($data);
            } else {
                return ApiResponse::error(trans("errors.appointment_not_found"), 200);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function calculateWaitingTime($appointment_id, $user_id)
    {
        $call_started_diff = 0;
        $getAppointment = Appointment::find($appointment_id);
        $getAllAppointmentDoctor = Appointment::where('doctor_id', $getAppointment->doctor_id)
            ->where('status', Constant::APPOINTMENT_STATUS_PENDING)
            ->where('type', Constant::APPOINTMENT_TYPE_INSTANT_VIDEO)->orderBy('id', 'ASC')->get()->pluck('doctor_id');
        if ($getAllAppointmentDoctor) {
            $appointmentNumber = array_search($user_id, $getAllAppointmentDoctor->toArray());
            if (is_int($appointmentNumber)) {
                $doctorFirstAppointment = Appointment::where('doctor_id', $getAppointment->doctor_id)
                    ->where('status', Constant::APPOINTMENT_STATUS_PENDING)->orderBy('id', 'ASC')->first();
                if ($doctorFirstAppointment->call_started) {
                    $start  = new Carbon($doctorFirstAppointment->call_started);
                    $end    = Carbon::now();
                    $call_started_diff = $start->diffInSeconds($end);
                }
                return ($appointmentNumber * Constant::APPOINTMENT_INSTANT_TIME) -
                    $call_started_diff > 0 ? ($appointmentNumber * Constant::APPOINTMENT_INSTANT_TIME) -
                    $call_started_diff : 0;
            }

            return Constant::APPOINTMENT_INSTANT_TIME;
        }
        return Constant::APPOINTMENT_INSTANT_TIME;
    }

    public function getAssessmentQuestions()
    {
        return AssessmentQuestionResource::collection(EducationalAssessmentQuestion::get());
    }

    public function patientConnected(Request $request)
    {
        $getAppointment = Appointment::find($request->id);
        if (!$getAppointment) {
            return ApiResponse::error(trans('errors.invalid_appointment_id'));
        }
        $getAppointment->is_patient_connected = true;
        $getAppointment->save();
        return ApiResponse::success(trans('success.patient_connected'));
    }

    public function callTime(Request $request)
    {
        $decryptedAppointmentId = decrypt($request->appointment_id);
        $validator = Validator::make(['appointment_id' => $decryptedAppointmentId], [
            'appointment_id' => 'required|exists:appointments,id'

        ], [
            'appointment_id.required' => trans('errors.appointment_id_required'),
            'appointment_id.exists' => trans('errors.invalid_appointment_id'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $getAppointment = Appointment::find($decryptedAppointmentId);
        $in_person_call_time = $this->patientService->calculateRemainingTime(
            $getAppointment->id,
            Constant::APPOINTMENT_IN_PERSON,
            $getAppointment->doctor_id
        );

        return ApiResponse::success(['in_person_call_time' => $in_person_call_time]);
    }
}
