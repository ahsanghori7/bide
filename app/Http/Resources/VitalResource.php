<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'patient_id' => $this->patient_id,
                'heart_rate' => $this->heart_rate ?? '00',
                'blood_pressure_systolic' => $this->blood_pressure_systolic ?? '00',
                'blood_pressure_diastolic' => $this->blood_pressure_diastolic ?? '00',
                'bmi' => $this->bmi ?? '00',
                'temperature' => $this->temperature ?? '00',
                'glucometer_result' => $this->glucometer_result ?? '00',
                'weight' => $this->weight ?? '00',
                'height' => $this->height ?? '00',
            ];
        } else {
            return [];
        }
    }
}
