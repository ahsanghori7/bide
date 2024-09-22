<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'marital_status' => $this->marital_status,
                'occupation' => $this->occupation,
                'lifestyle' => $this->lifestyle,
                'father_diabetic' => $this->father_diabetic,
                'mother_diabetic' => $this->mother_diabetic,
                'spouse_diabetic' => $this->spouse_diabetic,
                'brother_diabetic' => $this->brother_diabetic,
                'sister_diabetic' => $this->sister_diabetic,
                'children_diabetic' => $this->children_diabetic,
                'live_birth' => $this->live_birth,
                'still_birth' => $this->still_birth,
                'neonatal_deaths' => $this->neonatal_deaths,
                'abortion' => $this->abortion,
        ];
    }
}
