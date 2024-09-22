<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\StatusMappingService;

class DoctorQueueResource extends JsonResource
{
    public function toArray($request)
    {
        $statusMappingService = app(StatusMappingService::class);

        return [
            'appointment_id' => encrypt($this->appointment_id),
            'queue_id' => $this->id,
            'status_key' => $this->status,
            'status' => $statusMappingService->mapStatus($this->status),
            'patient_verified' => $this->patient_verified ? true : false,
            'patient_id' => $this->patient->id,
            'name' => $this->patient->name,
            'mr_no' => $this->patient->mr_no,
            'gender' => $this->patient->gender,
            'work_address' => $this->patient->work_address,
            'clinic_name' => $request->user()->clinics->first()->name,
            'type' => $this->appointment ? $statusMappingService->mapStatus($this->appointment->type) : ''
        ];
    }
}
