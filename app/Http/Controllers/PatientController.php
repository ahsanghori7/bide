<?php

namespace App\Http\Controllers;

use App\Http\Common\Constant;
use App\Http\Requests\PatientBasicInfoRequest;
use App\Http\Requests\PersonalHistoryRequest;
use Illuminate\Http\Request;
use App\Models\DoctorQueue;
use App\Http\Responses\ApiResponse;
use App\Models\LabReport;
use App\Models\Patient;
use App\Models\PatientDiabetesHistory;
use App\Models\PatientMedicalHistory;
use App\Models\PatientPersonalHistory;
use App\Models\PatientVitals;
use App\Models\Smbg;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DoctorQueueResource;
use App\Http\Resources\EthnicitiesResource;
use App\Http\Resources\LifestyleResource;
use App\Http\Resources\OccupationResource;
use App\Http\Resources\PatientResource;
use App\Models\Appointment;
use App\Models\Ethnicities;
use App\Models\Lifestyle;
use App\Models\Occupation;
use App\Services\DoctorService;
use App\Services\PatientService;
use Carbon\Carbon;

class PatientController extends Controller
{
    private $PatientService;
    private $doctorService;

    public function __construct(PatientService $PatientService, DoctorService $doctorService)
    {
        $this->PatientService = $PatientService;
        $this->doctorService = $doctorService;
    }

    public function doctorQueue(Request $request)
    {
        $queues = DoctorQueue::with('patient')
            ->where(['doctor_id' => $request->user()->id])
            ->orderByRaw(
                "CASE WHEN status = 'in-progress' THEN 0 
                WHEN status = 'waiting' THEN 1
                WHEN status = 'in-queue' THEN 2 
                WHEN status = 'cancel' THEN 3 
                WHEN status = 'complete' THEN 4 END"
            )
            ->orderBy('id', 'asc')->get();

        return DoctorQueueResource::collection($queues);
    }

    public function lobby(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'mr_no' => 'required|exists:patient_info,mr_no'
            ], [
                'mr_no.required' => trans('errors.mr_no_required'),
                'mr_no.exists' => trans('errors.invalid_mr_no'),
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $patient = Patient::where('mr_no', $request->mr_no)->first();

            $found = DoctorQueue::where(['patient_id' => $patient->id])
                ->whereDate('created_at', Carbon::now())->count();

            if ($found == 0) {
                return ApiResponse::error(trans('errors.null_appointment'), 404);
            }

            $recentDoctorQueue =  DoctorQueue::with('appointment')->where(['patient_id' => $patient->id])
                ->whereDate('created_at', Carbon::now())->whereIn(
                    'status',
                    [Constant::QUEUE_STATUS_INQUEUE, Constant::QUEUE_STATUS_WAITING, Constant::QUEUE_STATUS_PROGRESS]
                )->orderby('created_at', 'desc')->first();

            if (
                $recentDoctorQueue
            ) {
                if (
                    $recentDoctorQueue->status == Constant::QUEUE_STATUS_PROGRESS &&
                    $recentDoctorQueue->appointment->is_doctor_connected == 0 &&
                    $recentDoctorQueue->appointment->call_started == null
                ) {
                    return ApiResponse::success(trans('success.re_join'), 200);
                }
                $recentDoctorQueue->update(['patient_verified' => true, 'status' => Constant::QUEUE_STATUS_WAITING]);
                $updatedRecords = DoctorQueue::where(
                    ['patient_id' => $patient->id, 'status' => Constant::QUEUE_STATUS_WAITING]
                )->first();
                $appointment_id = encrypt($updatedRecords->appointment_id);
                return ApiResponse::success(['appointment_id' => $appointment_id]);
            } else {
                $cancelQueue = DoctorQueue::where(['patient_id' => $patient->id])
                    ->whereDate('created_at', Carbon::now())->where(
                        'status',
                        Constant::QUEUE_STATUS_CANCELLED
                    )->count();
                if ($cancelQueue && $cancelQueue > 0) {
                    return ApiResponse::error(trans('errors.booking_cancel'), 404);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function patientList(Request $request)
    {
        $patients = Patient::with('lastVisit')->orderby('created_at', 'desc')->paginate(4);
        return PatientResource::collection($patients);
    }

    public function search(Request $request)
    {
        $query = Patient::query();

        if (!$request->search_key) {
            if ($request->has('mr_no')) {
                $query->where('mr_no', $request->input('mr_no'));
            }

            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }

            if ($request->has('mobile_number')) {
                $query->where('mobile_number', $request->input('mobile_number'));
            }

            if ($request->has('cnic')) {
                $query->where('cnic', $request->input('cnic'));
            }
        }

        if ($request->search_key) {
            $query->where('mobile_number', 'like', '%' . $request->search_key . '%')
                ->orWhere('name', 'like', '%' . $request->search_key . '%')
                ->orWhere('mr_no', 'like', '%' . $request->search_key . '%');
        }
        $patients = $query->get();

        return PatientResource::collection($patients);
    }

    public function switchDoctor(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'queue_id' => 'required|exists:doctor_queues,id',
            'doctor_id' => 'required|exists:users,id'
        ], [
            'queue_id.required' => trans('errors.queue_id_required'),
            'queue_id.exists' => trans('errors.invalid_queue_id'),
            'doctor_id.required' => trans('errors.doctor_id_required'),
            'doctor_id.exists' => trans('errors.invalid_doctor_id'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $role_id = User::where('id', $request->doctor_id)->first()->role_id;

        if ($role_id !== 2) {
            return ApiResponse::error(trans('errors.not_doctor'));
        }

        $doctors = $this->doctorService->availableDoctor($request);
        if ($doctors) {
            $queue = DoctorQueue::where('id', $request->queue_id)->first();
            $queue->update(['doctor_id' => $request->doctor_id]);
            Appointment::where('id', $queue->appointment_id)->update(['doctor_id' => $request->doctor_id]);
            return ApiResponse::success(trans('success.dr_switch'));
        } else {
            return ApiResponse::error(trans('errors.doctor_not_available'), 404);
        }
    }

    public function processBasicInfo(PatientBasicInfoRequest $request, $patient_id = null)
    {
        try {
            $patient = Patient::updateorcreate(
                ['id' => $patient_id],
                [
                    'mr_no' => $request->input('mr_no'),
                    'name' => $request->input('name'),
                    'gender' => $request->input('gender'),
                    'date_of_birth' => $request->input('dob'),
                    'cnic' => $request->input('cnic'),
                    'mobile_number' => $request->input('mobile_number'),
                    'email' => $request->input('email'),
                    'telephone' => $request->input('telephone'),
                    'address' => $request->input('address'),
                    'work_address' => $request->input('work_address'),
                    'ethnicity' => $request->input('ethnicity'),
                    'clinic_user_id' => $request->user()->clinic_user_id,
                    'status' => 'active'
                ]
            );
            return ApiResponse::success(['patient_id' => $patient->id], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function processPersonalHistory(PersonalHistoryRequest $request)
    {
        try {
            PatientPersonalHistory::updateorcreate(['patient_id' => $request->input('patient_id')], [
                'patient_id' => $request->input('patient_id'),
                'marital_status' => $request->input('marital_status'),
                'occupation' => $request->input('occupation'),
                'lifestyle' => $request->input('lifestyle'),
                'father_diabetic' => $request->input('father_diabetic'),
                'father_diabetic_text' => $request->input('father_diabetic_text'),
                'mother_diabetic' => $request->input('mother_diabetic'),
                'mother_diabetic_text' => $request->input('mother_diabetic_text'),
                'spouse_diabetic' => $request->input('spouse_diabetic'),
                'spouse_diabetic_text' => $request->input('spouse_diabetic_text'),
                'brother_diabetic' => $request->input('brother_diabetic'),
                'brother_diabetic_text' => $request->input('brother_diabetic_text'),
                'sister_diabetic' => $request->input('sister_diabetic'),
                'sister_diabetic_text' => $request->input('sister_diabetic_text'),
                'children_diabetic' => $request->input('children_diabetic'),
                'children_diabetic_text' => $request->input('children_diabetic_text'),
                'live_birth' => $request->input('live_birth'),
                'live_birth_text' => $request->input('live_birth_text'),
                'still_birth' => $request->input('still_birth'),
                'still_birth_text' => $request->input('still_birth_text'),
                'neonatal_deaths' => $request->input('neonatal_deaths'),
                'neonatal_deaths_text' => $request->input('neonatal_deaths_text'),
                'abortion' => $request->input('abortion'),
                'abortiont_ext' => $request->input('abortiont_ext'),
            ]);
            $msg = trans('success.personal_history_created');
            return ApiResponse::success($msg, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function processMedicalHistory(Request $request)
    {

        PatientMedicalHistory::updateorcreate(['patient_id' => $request->input('patient_id')], [
            'patient_id' => $request->input('patient_id'),
            'previous_treat' => $request->input('previous_treat'),
            'previous_treat_text' => $request->input('previous_treat_text'),
            'eye_drop' => $request->input('eye_drop'),
            'eye_drop_text' => $request->input('eye_drop_text'),
            'walk' => $request->input('walk'),
            'previous_medication' => $request->input('previous_medication'),
            'previous_medication_text' => $request->input('previous_medication_text'),
        ]);
        $msg = trans('success.medical_created');
        return ApiResponse::success($msg, 201);
    }

    // public function processLabReports(Request $request, $report_id = null)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'patient_id' => 'required|numeric|exists:patient_info,id'
    //     ], [
    //         'patient_id.required' => trans('errors.patient_id_required'),
    //         'patient_id.numeric' => trans('errors.patinet_id_numaric'),
    //         'patient_id.exists' => trans('errors.patinet_id_invalid'),
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()->first()], 422);
    //     }

    //     LabReport::updateorcreate(['id' => $report_id, 'patient_id' => $request->input('patient_id')], [
    //         'patient_id' => $request->input('patient_id'),
    //         'fbs' => $request->input('fbs'),
    //         'rbs' => $request->input('rbs'),
    //         'hba1c' => $request->input('hba1c'),
    //         's_creatinine' => $request->input('s_creatinine'),
    //         'urine_dr' => $request->input('urine_dr'),
    //         'microalbumin' => $request->input('microalbumin'),
    //         'tfh_u_protein' => $request->input('tfh_u_protein'),
    //         'tfh_cct' => $request->input('tfh_cct'),
    //         'total_lipid' => $request->input('total_lipid'),
    //         'cholesterol' => $request->input('cholesterol'),
    //         'triglyceride' => $request->input('triglyceride'),
    //         'ldl' => $request->input('ldl'),
    //         'hdl' => $request->input('hdl'),
    //         'ecg' => $request->input('ecg'),
    //         'ett' => $request->input('ett'),
    //         'echo' => $request->input('echo'),
    //         't3' => $request->input('t3'),
    //         't4' => $request->input('t4'),
    //         'tsh' => $request->input('tsh'),
    //         'cds' => $request->input('cds'),
    //         'glucose' => $request->input('glucose'),
    //         'hbs' => $request->input('hbs'),
    //         'xray_chest' => $request->input('xray_chest'),
    //         'remarks' => $request->input('remarks'),
    //         'lab_name' => $request->input('lab_name'),
    //         'date' => $request->input('date'),
    //         'alb' => $request->input('alb'),
    //         'hup' => $request->input('hup')
    //     ]);
    //     $msg = trans('success.labs_added');
    //     return ApiResponse::success($msg, 201);
    // }
    public function processLabReports(Request $request, $report_id = null)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|numeric|exists:patient_info,id'
        ], [
            'patient_id.required' => trans('errors.patient_id_required'),
            'patient_id.numeric' => trans('errors.patinet_id_numaric'),
            'patient_id.exists' => trans('errors.patinet_id_invalid'),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $data = [
            'patient_id' => $request->input('patient_id'),
            'fbs' => $request->input('fbs'),
            'rbs' => $request->input('rbs'),
            'hba1c' => $request->input('hba1c'),
            's_creatinine' => $request->input('s_creatinine'),
            'urine_dr' => $request->input('urine_dr'),
            'microalbumin' => $request->input('microalbumin'),
            'tfh_u_protein' => $request->input('tfh_u_protein'),
            'tfh_cct' => $request->input('tfh_cct'),
            'total_lipid' => $request->input('total_lipid'),
            'cholesterol' => $request->input('cholesterol'),
            'triglyceride' => $request->input('triglyceride'),
            'ldl' => $request->input('ldl'),
            'hdl' => $request->input('hdl'),
            'ecg' => $request->input('ecg'),
            'ett' => $request->input('ett'),
            'echo' => $request->input('echo'),
            't3' => $request->input('t3'),
            't4' => $request->input('t4'),
            'tsh' => $request->input('tsh'),
            'cds' => $request->input('cds'),
            'glucose' => $request->input('glucose'),
            'hbs' => $request->input('hbs'),
            'xray_chest' => $request->input('xray_chest'),
            'remarks' => $request->input('remarks'),
            'lab_name' => $request->input('lab_name'),
            'date' => $request->input('date'),
            'alb' => $request->input('alb'),
            'hup' => $request->input('hup')
        ];
        if ($report_id) {
            $report = LabReport::find($report_id);
            if ($report) {
                $report->update($data);
                $msg = trans('success.labs_updated');
                return ApiResponse::success($msg, 200);
            }
        }
        LabReport::create($data);
        $msg = trans('success.labs_added');
        return ApiResponse::success($msg, 201);
    }


    public function processDiabetesHistory(Request $request)
    {

        PatientDiabetesHistory::updateorcreate(
            ['patient_id' =>  $request->input('patient_id')],
            [
                'patient_id' => $request->input('patient_id'),
                'type' => $request->input('type'),
                'year_diagnosed' => $request->input('year_diagnosed'),
                'insulin' => $request->input('insulin'),
                'insulin_details' => $request->input('insulin_details'),
                'keto_diagnosis' => $request->input('keto_diagnosis'),
                'keto_details' => $request->input('keto_details'),
                'remarks' => $request->input('remarks')
            ]
        );
        $msg = trans('success.diabetes_added');
        return ApiResponse::success($msg, 201);
    }

    // public function processSmbg(Request $request, $smbg = null)
    // {
    //     Smbg::updateorcreate(
    //         [
    //             'id' => $smbg
    //         ],
    //         [
    //             'patient_id' => $request->input('patient_id'),
    //             'pre_breakfast' => $request->input('pre_breakfast'),
    //             'post_breakfast' => $request->input('post_breakfast'),
    //             'pre_lunch' => $request->input('pre_lunch'),
    //             'post_lunch' => $request->input('post_lunch'),
    //             'pre_dinner' => $request->input('pre_dinner'),
    //             'post_dinner' => $request->input('post_dinner'),
    //             'before_bed' => $request->input('before_bed'),
    //             'random' => $request->input('random'),
    //         ]
    //     );
    //     $msg = trans('success.smbgs_added');
    //     return ApiResponse::success('success.smbgs_updated');
    // }

    public function processSmbg(Request $request, $smbg = null)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|integer',
            'pre_breakfast' => 'nullable|numeric',
            'post_breakfast' => 'nullable|numeric',
            'pre_lunch' => 'nullable|numeric',
            'post_lunch' => 'nullable|numeric',
            'pre_dinner' => 'nullable|numeric',
            'post_dinner' => 'nullable|numeric',
            'before_bed' => 'nullable|numeric',
            'random' => 'nullable|numeric',
        ]);
        $smbgRecord = Smbg::find($smbg);

        if ($smbgRecord) {
            $smbgRecord->update($validatedData);
            $msg = trans('success.smbgs_updated');
            $status = 200;
        } else {
            Smbg::create($validatedData);
            $msg = trans('success.smbgs_added');
            $status = 201;
        }

        return ApiResponse::success($msg, $status);
    }

    public function processVitals(Request $request, $vital_id = null)
    {
        PatientVitals::updateOrCreate(
            ['id' => $vital_id],
            [
                'patient_id' => $request->input('patient_id'),
                'heart_rate' => $request->input('heart_rate'),
                'blood_pressure_systolic' => $request->input('blood_pressure_systolic'),
                'blood_pressure_diastolic' => $request->input('blood_pressure_diastolic'),
                'bmi' => $this->PatientService->bmiCalculate($request),
                'temperature' => $request->input('temperature'),
                'glucometer_result' => $request->input('glucometer_result'),
                'weight' => $request->input('weight'),
                'height' => $request->input('height'),
            ]
        );
        $msg = trans('success.vital_added');
        return ApiResponse::success($msg, 201);
    }

    /**
     * Create getPatient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPatient(Request $request)
    {
        $result = $this->PatientService->getPatient($request->input('patient_id'));
        return response()->json($result);
    }

    public function getSmbg(Request $request)
    {
        $result = $this->PatientService->fetchSmbg($request);
        return response()->json($result);
    }

    public function getLabs(Request $request)
    {
        $result = $this->PatientService->fetchReports($request);
        return response()->json($result);
    }


    public function getVitals(Request $request)
    {
        $result = $this->PatientService->fetchVitals($request);
        return response()->json($result);
    }

    public function lastMrNo()
    {
        $patinet = Patient::orderby('mr_no', 'desc')->first();
        if ($patinet) {
            $mr_no = ($patinet->mr_no + 1);
        } else {
            $mr_no = 1;
        }
        return ApiResponse::success(['mr_no' => $mr_no], 200);
    }

    public function ethnicities()
    {
        return EthnicitiesResource::collection(Ethnicities::get());
    }

    public function lifestyleAndOccupation()
    {
        $lifestyles = Lifestyle::get();
        $occupations = Occupation::get();

        return response()->json([
            'lifestyles' => LifestyleResource::collection($lifestyles),
            'occupations' => OccupationResource::collection($occupations),
        ]);
    }
}
