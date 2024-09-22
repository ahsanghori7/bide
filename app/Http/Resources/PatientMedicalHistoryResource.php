<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMedicalHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'patient_id' => $this->patient_id,
                'previous_treat' => $this->previous_treat,
                'previous_treat_text' => $this->previous_treat_text,
                'eye_drop' => $this->eye_drop,
                'eye_drop_text' => $this->eye_drop_text,
                'walk' => $this->walk,
                'previous_medication' => $this->previous_medication,
                'previous_medication_text' => $this->previous_medication_text,
                'date' => $this->created_at,
            ];
        } else {
            return [];
        }
    }
}
