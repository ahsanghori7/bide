<?php

namespace App\Http\Controllers;

use App\Http\Common\Constant;
use App\Http\Resources\DashboardResource;
use Illuminate\Http\Request;
use App\Models\DoctorQueue;
use App\Models\EducatorQueue;
use App\Http\Resources\RecentPatientResources;
use App\Http\Resources\WaitingResource;
use App\Models\Appointment;
use App\Models\WaitingQueue;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function queues(Request $request)
    {

        $doctorQueues = DoctorQueue::with(['patient', 'appointment', 'token', 'doctor'])
            ->where(['clinic_user_id' => $request->user()->clinic_user_id])
            ->whereDate('created_at', Carbon::today())
            ->whereIn('status', [Constant::QUEUE_STATUS_WAITING, Constant::QUEUE_STATUS_INQUEUE])
            ->orderby('created_at')->get();

        $educatorQueues = EducatorQueue::with(['patient', 'appointment', 'token', 'doctor'])
            ->where('clinic_user_id', $request->user()->clinic_user_id)
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', Constant::EDUCATOR_QUEUE_STATUS_START);
            })
            ->orderByRaw("CASE WHEN status = 'in-progress' THEN 0 ELSE 1 END")
            ->orderBy('created_at')
            ->get();

        $patients = Appointment::with('patient')
            ->whereIn('status', [CONSTANT::APPOINTMENT_STATUS_CANCELLED, CONSTANT::APPOINTMENT_STATUS_COMPLETED])
            ->where('clinic_user_id', $request->user()->clinic_user_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        $currentDate = Carbon::now()->toDateString();
        $waiting = WaitingQueue::with('patient')->whereDate('created_at', $currentDate)
            ->where(['clinic_user_id' => $request->user()->clinic_user_id, 'status' => 'added'])
            ->orderBy('created_at')
            ->get();

        $doctorQueueResources = DashboardResource::collection($doctorQueues);
        $educatorQueueResources = DashboardResource::collection($educatorQueues);
        $recentPatientResources = RecentPatientResources::collection($patients);
        $waitingListResources = WaitingResource::collection($waiting);
        $totalCount = Appointment::where(
            ['date' => $currentDate, 'clinic_user_id' => $request->user()->clinic_user_id]
        )->count();
        $totalCompletedCount = Appointment::where(
            [
                'status' => Constant::APPOINTMENT_STATUS_COMPLETED, 'date' => $currentDate,
                'clinic_user_id' => $request->user()->clinic_user_id
            ]
        )->count();

        return [
            'doctor_queues' => $doctorQueueResources,
            'educator_queues' => $educatorQueueResources,
            'waiting_list' => $waitingListResources,
            'recent_patients' => $recentPatientResources,
            'total_count' => $totalCount,
            'total_complete_count' => $totalCompletedCount
        ];
    }
}
