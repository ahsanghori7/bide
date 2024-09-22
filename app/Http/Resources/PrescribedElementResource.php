<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescribedElementResource extends JsonResource
{
    public function toArray($request)
    {
        $element_name = null;

        if ($this->type === 'insulin') {
            $element_name = $this->insuline_name;
        } elseif ($this->type === 'medicine') {
            $element_name = $this->medicine_name;
        } elseif ($this->type === 'lab') {
            $element_name = $this->lab_name;
        }

        return [
            'id' => $this->id,
            'morning' => $this->morning,
            'afternoon' => $this->noon,
            'evening' => $this->evening,
            'night' => $this->night,
            'prescription_id' => $this->prescription_id,
            'prescription_element_id' => $this->prescription_element_id,
            'type' => $this->type,
            'element_name' => $element_name,
            'generic_id' => $this->generic_id,
            'generic' => $this->generic_name,
            'is_after_meal' => $this->is_after_meal,
            'type_id' => $this->type_id,
            'type_name' => $this->type_name,
            'route_id' => $this->route_id,
            'route' => $this->route_name,
            'item_strength_id' => $this->item_strength_id,
            'item_strength' => $this->item_strenght,
            'remarks' => $this->remarks,
            'is_before_meal' => $this->is_before_meal,
            'number_of_days' => $this->number_of_days,
            'dosage' => $this->dosage,
            'per_day' => $this->per_day,
            'unit' => $this->unit,
        ];
    }
}
