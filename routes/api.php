<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DoctorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/resendOtp', [AuthController::class, 'resendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/ethnicities', [PatientController::class, 'ethnicities']);
Route::get('/patient_connected', [ConsultationController::class, 'patientConnected']);
Route::get('/patient-info-by-mr', [AppointmentController::class, 'getAppointmentPatientInfoByMRNumber']);
Route::get('/generate-agora-rtm-token', [ConsultationController::class, 'rtmToken']);
Route::get('/lifestyle-occupation', [PatientController::class, 'lifestyleAndOccupation']);

Route::prefix('patient')->group(function () {
    Route::post('lobby', [PatientController::class, 'lobby']);
    Route::get('/instant-consultation/start', [ConsultationController::class, 'startConsultaion']);
});

Route::prefix('prescription')->group(function () {
    Route::get('/medicine-tab-info', [PrescriptionController::class, 'getMedicineTabInfo']);
    Route::get('/insulin-tab-info', [PrescriptionController::class, 'getInsulinTabInfo']);
    Route::get('/lab-list', [PrescriptionController::class, 'getLabTestInfo']);
    Route::get('/medicine-generic/{id}', [PrescriptionController::class, 'getMedicineGenerics']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user-info', [AuthController::class, 'userInfo']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('doctor')->group(function () {
        Route::get('awaiting', [PatientController::class, 'doctorQueue'])->middleware('doctor');
        Route::post('switch-doctor', [PatientController::class, 'switchDoctor'])->middleware('educator');
        Route::get('listing', [DoctorController::class, 'doctorListing'])->middleware('educator');
    });
    Route::prefix('patient')->middleware('educator')->group(function () {
        Route::get('list', [PatientController::class, 'patientList']);
        Route::get('/search', [PatientController::class, 'search'])->name('search');
        Route::post('add', [PatientController::class, 'processBasicInfo']);
        Route::put('update/{id}', [PatientController::class, 'processBasicInfo']);
        Route::post('add-personal-history', [PatientController::class, 'processPersonalHistory']);
        Route::post('add-medical-history', [PatientController::class, 'processMedicalHistory']);
        Route::post('add-lab-reports', [PatientController::class, 'processLabReports']);
        Route::put('update-lab-report/{id}', [PatientController::class, 'processLabReports']);
        Route::post('add-diabetes-history', [PatientController::class, 'processDiabetesHistory']);
        Route::post('add-smbg', [PatientController::class, 'processSmbg']);
        Route::put('update-smbg/{id}', [PatientController::class, 'processSmbg']);
        Route::get('get-smbg', [PatientController::class, 'getSmbg']);
        Route::get('get-reports', [PatientController::class, 'getLabs']);
        Route::post('add-vital', [PatientController::class, 'processVitals']);
        Route::put('update-vital/{id}', [PatientController::class, 'processVitals']);
        Route::get('get-vitals', [PatientController::class, 'getVitals']);
        Route::get('last-mr-no', [PatientController::class, 'lastMrNo']);
    });

    Route::prefix('consultation')->group(function () {
        Route::get('/last-educational-assessments', [ConsultationController::class, 'showAssessment'])->middleware('educator');
        Route::post('/assessments-educational', [ConsultationController::class, 'saveEduAssessment'])->middleware('educator');
        Route::post('/start-assessment', [ConsultationController::class, 'startAssessment'])->middleware('educator');
        Route::post('/generate-agora-rtm-token', [ConsultationController::class, 'startConsultation'])->withoutMiddleware('auth:api');
        Route::get('/patient-details', [PatientController::class, 'getPatient'])->middleware('educator');
        Route::get('/prescriptions', [ConsultationController::class, 'getPrescription'])->middleware('educator');
        Route::get('/patient-info', [AppointmentController::class, 'getAppointmentPatientInfo'])->middleware('doctor');
        Route::get('/generate-agora-link', [ConsultationController::class, 'generateAgoraLink'])->withoutMiddleware('auth:api');
        Route::post('/assessments-dietary', [ConsultationController::class, 'saveDietaryAssessment'])->middleware('educator');
        Route::get('/assessments-dietary', [ConsultationController::class, 'getDietaryAssessment'])->middleware('educator');
        Route::get('/assessments-questions', [ConsultationController::class, 'getAssessmentQuestions'])->middleware('educator');
        Route::get('/educational-assessments', [ConsultationController::class, 'patinetAssessments'])->middleware('educator');
        Route::get('/in-person-call-time', [ConsultationController::class, 'callTime'])->middleware('doctor');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('queue-and-waiting-list', [DashboardController::class, 'queues'])->middleware('educator');
    });

    Route::prefix('appointment')->group(function () {
        Route::post('create-appointment', [AppointmentController::class, 'createAppointment'])->middleware('educator');
        Route::post('add-waiting-list', [AppointmentController::class, 'createWatingList'])->middleware('educator');
        Route::delete('delete-appointment/{id}', [AppointmentController::class, 'deleteQueue'])->middleware('educator');
        Route::post('/cancel-appointment', [AppointmentController::class, 'cancelAppointment'])->middleware('doctor');
        Route::post('/complete', [AppointmentController::class, 'appointmentComplete'])->middleware('doctor');
        Route::post('/disconnect-doctor', [AppointmentController::class, 'disconnectDoctor'])->middleware('doctor');
    });
});
