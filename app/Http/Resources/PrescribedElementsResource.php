<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescribedElementsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'morning' => $this->morning,
            'afternoon' => $this->noon,
            'evening' => $this->evening,
            'night' => $this->night,
            'prescription_id' => $this->prescription_id,
            'prescription_element_id' => $this->prescription_element_id,
            'type' => $this->type,
            'generic_id' => $this->generic_id,
            'generic' => $this->generic_name,
            'is_after_meal' => $this->is_after_meal,
            //medName
            //medicine
            'type' => $this->type,
            'type_id' => $this->type_name,
            'route' => $this->route_name,
            //routeName
            'element_name' => $element_name,
            'item_strenght' => $this->item_strenght,
            'remarks' => $this->remarks,
            'is_after_meal' => $this->is_after_meal,
            'is_before_meal' => $this->is_before_meal,
            'duration' => $this->number_of_days,
            'number_of_days' => $this->number_of_days,
            'item_strength_id' => $this->item_strength_id,
            //strengthName
            'strength' => $this->item_strength_id,
            'duration_id' => $this->duration_id,
            'unit' => $this->unit,
            'dosage' => $this->dosage,
            'per_day' => $this->per_day
        ];
    }
}
