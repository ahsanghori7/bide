<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientDiabetesHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'patient_id' => $this->patient_id ?? null,
            'type' => $this->type ?? null,
            'year_diagnosed' => $this->year_diagnosed ?? null,
            'insulin' => $this->insulin ?? null,
            'insulin_details' => $this->insulin_details ?? null,
            'keto_diagnosis' => $this->keto_diagnosis ?? null,
            'keto_details' => $this->keto_details ?? null,
            'remarks' => $this->remarks ?? null,
            'date' => $this->created_at ?? null,
        ];
    }
}
