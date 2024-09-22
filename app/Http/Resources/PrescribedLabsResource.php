<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrescribedLabsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'prescription_id' => $this->prescription_id,
            'prescription_element_id' => $this->prescription_element_id,
            'type' => $this->type,
            'lab' => $this->lab_name,
            'return' => true
        ];
    }
}
