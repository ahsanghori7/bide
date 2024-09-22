<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescribedMedicinesResource extends JsonResource
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
            'medicine' => $this->medicine_name,
            'genericName' => $this->generic_name,
            'generic' => $this->generic_id,
            'is_after_meal' => $this->is_after_meal,
            'type_id' => $this->type_id,
            'route' => $this->route_id,
            'routeName' => $this->route_name,
            'strength' => $this->item_strength_id,
            'strengthName' => $this->item_strenght,
            'remarks' => $this->remarks,
            'is_before_meal' => $this->is_before_meal,
            'number_of_days' => $this->number_of_days,
            'unit' => $this->unit,
            'return' => true
        ];
    }
}
