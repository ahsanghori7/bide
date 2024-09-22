<?php

namespace App\Services;

use App\Http\Common\Constant;
use App\Models\DoctorQueue;
use App\Models\User;

class DoctorService
{
    public function availableDoctor($request)
    {
        $clinic_id = $request->user()->clinics[0]->id;
        $doctors = User::withCount(['appointments as appointments_count' => function ($query) {
            $query->whereDate('date', now()->toDateString())
                  ->where('status', '!=', 'cancel');
        }])
        ->whereHas('clinics', function ($query) use ($clinic_id) {
            $query->where('clinic_id', $clinic_id);
        })
        ->where('is_login', true)
        ->where(['role_id' => 2])
        ->get();

        if ($doctors->isEmpty()) {
            return false;
        }

        return $doctors;
    }


    public static function countPataintsInQueue($request)
    {
        return DoctorQueue::where(
            ['doctor_id' => $request->user()->id, 'status' => Constant::QUEUE_STATUS_INQUEUE]
        )->count();
    }
}
