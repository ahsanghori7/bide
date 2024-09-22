<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientVitalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'heart_rate' => $this->heart_rate ?? "00",
            'blood_pressure_systolic' => $this->blood_pressure_systolic ?? "00",
            'blood_pressure_diastolic' => $this->blood_pressure_diastolic ?? "00",
            'bmi' => $this->bmi ?? "00",
            'temperature' => $this->temperature ?? "00",
            'glucometer_result' => $this->glucometer_result ?? "00",
            'weight' => $this->weight ?? "00",
            'height' => $this->height ?? "00",
            'created_at' => $this->created_at ? $this->created_at->format('d/m/Y') : ''

        ];
    }
}
