<?php

namespace App\Http\Resources;

use App\Services\StatusMappingService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray($request)
    {
        $statusMappingService = app(StatusMappingService::class);

        return [
            'queue_id' => $this->id,
            'appointment_date' => $this->appointment->date,
            'appointment_time' =>  Carbon::parse($this->appointment->time)->format('H:i'),
            'token_no' => $this->token->token,
            'educator_name' => $this->educator->name,
            'patient_name' => $this->patient->name . " (" .  strtoupper(substr($this->patient->gender, 0, 1)) . ")",
            'patient_no' => $this->patient->mobile_number,
            'doctor_name' => $this->doctor->name,
            'mr_no' => $this->patient->mr_no,
            'gender' => $this->patient->gender,
            'patient_no' => $this->patient->mobile_number,
            'type' => $statusMappingService->mapStatus($this->appointment->type),
        ];
    }
}
