<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'patient_id' => $this->patient_id,
                'marital_status' => $this->marital_status,
                'occupation' => $this->occupation,
                'lifestyle' => $this->lifestyle,
                'father_diabetic' => $this->father_diabetic,
                'father_diabetic_text' => $this->father_diabetic_text,
                'mother_diabetic' => $this->mother_diabetic,
                'mother_diabetic_text' => $this->mother_diabetic_text,
                'spouse_diabetic' => $this->spouse_diabetic,
                'spouse_diabetic_text' => $this->spouse_diabetic_text,
                'brother_diabetic' => $this->brother_diabetic,
                'brother_diabetic_text' => $this->brother_diabetic_text,
                'sister_diabetic' => $this->sister_diabetic,
                'sister_diabetic_text' => $this->sister_diabetic_text,
                'children_diabetic' => $this->children_diabetic,
                'children_diabetic_text' => $this->children_diabetic_text,
                'live_birth' => $this->live_birth,
                'live_birth_text' => $this->live_birth_text,
                'still_birth' => $this->still_birth,
                'still_birth_text' => $this->still_birth_text,
                'neonatal_deaths' => $this->neonatal_deaths,
                'neonatal_deaths_text' => $this->neonatal_deaths_text,
                'abortion' => $this->abortion,
                'abortiont_ext' => $this->abortiont_ext,
            ];
        } else {
            return [];
        }
    }
}
