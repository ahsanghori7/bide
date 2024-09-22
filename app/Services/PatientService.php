<?php

// app/Services/PatientService.php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientMedicalHistory;
use App\Models\PatientDiabetesHistory;
use App\Models\PatientVitals;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientHistoryResource;
use App\Http\Resources\PatientDiabetesHistoryResource;
use App\Http\Resources\PatientMedicalHistoryResource;
use App\Http\Resources\PatientMedicalHistoryResourceForAppointment;
use App\Http\Resources\PatientReportsResource;
use App\Http\Resources\PatientSmbgResource;
use App\Http\Resources\PatientVitalResource;
use App\Models\Appointment;
use App\Models\LabReport;
use App\Models\PatientPersonalHistory;
use App\Models\Smbg;
use Carbon\Carbon;
use DateTime;

class PatientService
{
    public static function patientMedicalHistory($patient_id)
    {
        return PatientMedicalHistory::where('patient_id', $patient_id)->first();
    }

    public static function patientDiabetesHistory($patient_id)
    {
        return PatientDiabetesHistory::where('patient_id', $patient_id)->orderBy('created_at', 'desc')
            ->first();
    }

    public static function patientVitals($patient_id)
    {
        return PatientVitals::where('patient_id', $patient_id)->orderBy('created_at', 'desc')
            ->get();
    }

    public static function labReport($patient_id)
    {
        return LabReport::where('patient_id', $patient_id)->orderBy('created_at', 'desc')
            ->get();
    }

    public static function smbg($patient_id)
    {
        return Smbg::where('patient_id', $patient_id)->orderBy('created_at', 'desc')->get();
    }

    public static function patientPersonalHistory($patient_id)
    {
        return PatientPersonalHistory::where('patient_id', $patient_id)->first();
    }


    public function getPatient($patient_id)
    {
        $patientInfo = Patient::where('id', $patient_id)->first();
        $patientPersonalHistory = self::patientPersonalHistory($patient_id);
        $patientDiabetesHistory = self::patientDiabetesHistory($patient_id);
        $patientVitals = self::patientVitals($patient_id);
        $patientLabReport = self::labReport($patient_id);
        $patientMedicalHistory = self::patientMedicalHistory($patient_id);
        $patientInfoCollection = new PatientResource($patientInfo);
        $patientPersonalHistoryCollection = new PatientHistoryResource($patientPersonalHistory);
        $patientMedicalHistoryCollection = new PatientMedicalHistoryResource($patientMedicalHistory);
        $patientDiabetesHistoryCollection = new PatientDiabetesHistoryResource($patientDiabetesHistory);
        $patientVitalsCollection = PatientVitalResource::collection($patientVitals);
        $patientReportCollection = PatientReportsResource::collection($patientLabReport);
        $patientMedicalArrayCollection = new PatientMedicalHistoryResourceForAppointment($patientMedicalHistory);

        return [
            'patient_info' => $patientInfoCollection,
            'patient_personal_history' => $patientPersonalHistoryCollection,
            'patient_medical_history' => $patientMedicalHistoryCollection,
            'patient_diabetes_history' => $patientDiabetesHistoryCollection,
            'patient_vitals' => $patientVitalsCollection,
            'patient_reports' => $patientReportCollection,
            'patient_medical_history_array' => $patientMedicalArrayCollection,
        ];
    }

    public function fetchSmbg($request)
    {
        $smbg = Smbg::where('patient_id', $request->patient_id)->orderBy('created_at', 'desc')
            ->get();
        return PatientSmbgResource::collection($smbg);
    }


    public function fetchReports($request)
    {
        $labReport = self::labReport($request->patient_id);
        return PatientReportsResource::collection($labReport);
    }

    public function patientForApp($patient_id)
    {
        $patientInfo = Patient::where('id', $patient_id)->first();
        $patientPersonalHistory = self::patientPersonalHistory($patient_id);
        $patientDiabetesHistory = self::patientDiabetesHistory($patient_id);
        $patientLabReport = self::labReport($patient_id);
        $patientMedicalHistory = self::patientMedicalHistory($patient_id);
        $patientSmgb = self::smbg($patient_id);

        return [
            'patient_info' => $patientInfo,
            'patient_personal_history' => $patientPersonalHistory,
            'patient_diabetes_history' => $patientDiabetesHistory,
            'patient_reports' => $patientLabReport,
            'patient_medical_history' => $patientMedicalHistory,
            'smgb' => $patientSmgb,
        ];
    }

    public function fetchVitals($request)
    {
        $vitals = self::patientVitals($request->patient_id);
        return PatientVitalResource::collection($vitals);
    }

    public function bmiCalculate($request)
    {
        $validatedData = $request->validate([
            'weight' => 'required',
            'height' => 'required',
            // Define more validation rules here
        ]);
        $weight_kg = $request->input('weight');
        $height_m = $request->input('height');

        $bmi = $weight_kg / ($height_m * $height_m);

        return $bmi;
    }

    public function ibwCalculate($patient_id, $date)
    {
        $patient = Patient::findOrFail($patient_id);
        $gender = $patient->gender;
        $ibw = 0;
        $lastVital = PatientVitals::where('patient_id', $patient_id)
            ->whereDate('created_at', $date)->orderby('created_at', 'desc')->first();
        if ($lastVital) {
            $height = $lastVital->height;
            if ($gender == 'Male') {
                $ibw = 22 * pow($height, 2);
            } elseif ($gender == 'Female') {
                $ibw = 22 * pow(($height - 0.1), 2);
            }
        }
        return $ibw;
    }

    public function getBmi($patient_id, $date)
    {
        $patient = PatientVitals::where('patient_id', $patient_id)
            ->whereDate('created_at', $date)->orderby('created_at', 'desc')->first();
        $bmi = 0;
        if ($patient) {
            $bmi = $patient->bmi;
        }
        return $bmi;
    }

    public function beeCalculate($patient_id, $date)
    {
        $lastVital = PatientVitals::where('patient_id', $patient_id)
            ->whereDate('created_at', $date)->orderby('created_at', 'desc')->first();
        $bee = 0;
        if ($lastVital) {
            $patient = Patient::findOrFail($patient_id);
            $dob = new DateTime($patient->date_of_birth);
            $currentDate = new DateTime();
            $age = $currentDate->diff($dob)->y;

            $weight_kg = $lastVital->weight;
            $height_cm = ($lastVital->height * 100);

            $bee = (66.47 + (13.75 * $weight_kg) + (5.003 * $height_cm)) - (6.775 * $age);
        }
        return $bee;
    }

    public function calculateRemainingTime($appointment_id, $time, $user_id)
    {
        $call_started_diff = 0;
        $getAppointment = Appointment::find($appointment_id);
        if ($getAppointment) {
            if ($getAppointment->call_started) {
                $start  = new Carbon($getAppointment->call_started);
                $end    = Carbon::now();
                $call_started_diff = $start->diffInSeconds($end);
            } else {
                $start  = new Carbon($getAppointment->created_at);
                $end    = Carbon::now();
                $call_started_diff = $start->diffInSeconds($end);
            }
            $remaining_time = $time - $call_started_diff;
            if ($remaining_time >= 0) {
                return $remaining_time;
            } else {
                return 0;
            }
        }

        return $time;
    }
}
