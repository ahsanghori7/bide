<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescribedInsulinesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'morning' => $this->morning,
            'afternoon' => $this->noon,
            'evening' => $this->evening,
            'night' => $this->night,
            'prescription_id' => $this->prescription_id,
            'prescription_element_id' => $this->prescription_element_id,
            'type' => $this->type,
            'insuline' => $this->insuline_name,
            'is_after_meal' => $this->is_after_meal,
            'is_before_meal' => $this->is_before_meal,
            'number_of_days' => $this->number_of_days,
            'unit' => $this->unit,
            'return' => true
        ];
    }
}
