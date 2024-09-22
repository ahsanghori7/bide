<?php

namespace App\Http\Resources;

use App\Services\StatusMappingService;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentPatientResources extends JsonResource
{
    public function toArray($request)
    {
        $statusMappingService = app(StatusMappingService::class);
        return [
            'id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'mobile_number' => $this->patient->mobile_number,
            'last_visit' => $this->patient->lastVisit ? $this->patient->lastVisit->date : null,
            'last_visit_status' =>  $statusMappingService->mapStatus($this->status),
            'mr_no' => $this->patient->mr_no,
        ];
    }
}
