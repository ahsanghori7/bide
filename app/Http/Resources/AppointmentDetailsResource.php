<?php

namespace App\Http\Resources;

use App\Http\Common\Constant;
use App\Services\PatientService;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        $patientService = app(PatientService::class);

        return [
            'id' => $this->id,
            'type' => $this->type,
            'time' => $this->time,
            'status' => $this->status,
            'remaining_time' => $patientService->calculateRemainingTime(
                $this->id,
                Constant::APPOINTMENT_INSTANT_TIME,
                $this->doctor_id
            )
        ];
    }
}
