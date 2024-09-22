<?php

namespace App\Http\Resources;

use App\Models\Patient;
use App\Services\StatusMappingService;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableDoctorResource extends JsonResource
{
    public function toArray($request)
    {
        $statusMappingService = app(StatusMappingService::class);

        return [
            'doctor_id' => $this->id,
            'doctor_name' => $this->name,
            'site' => isset($this->clinics) ? $this->clinics->first()->location : '',
            'count' => $this->appointments_count . '/' . optional($this->config)->daily_limit,
            'current_status' => $statusMappingService->mapStatus($this->getCurrentStatus()),
            'status' => $statusMappingService->mapStatus($this->getCurrentStatus()),
            'patient_name' => $this->appointments->where('is_doctor_connected', 1)->first() ? Patient::where('id', $this->appointments->where('is_doctor_connected', 1)->first()->patient_id)->first()->name : null,
            'limit_exced' => $this->appointments_count >= optional($this->config)->daily_limit ? true : false,
        ];
    }
}
