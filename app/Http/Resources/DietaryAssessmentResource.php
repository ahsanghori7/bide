<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DietaryAssessmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'appointment_id' => $this->appointment_id,
            'meal_entries_id' => $this->meal_entries_id,
            'fats_intake' => $this->fats_intake,
            'calories_intake' => $this->calories_intake,
            'calories_required' => $this->calories_required,
            'calories_advised' => $this->calories_advised,
            'activity_factor' => $this->activity_factor,
            'injury_factor' => $this->injury_factor,
            'compliance' => $this->compliance,
            'visit_no' => $this->visit_no,
            'cal_advised' => $this->cal_advised,
            'protein_intake' => $this->protein_intake,
            'sodium_intake' => $this->sodium_intake,
            'remarks' => $this->remarks,
            'bmi' => $this->bmi,
            'ibw' => $this->ibw,
            'bee' => $this->bee,
            'cereal_misc' => $this->cereal_misc,
            'fats_misc' => $this->fats_misc,
            'calories_misc' => $this->calories_misc,
        ];
    }
}
