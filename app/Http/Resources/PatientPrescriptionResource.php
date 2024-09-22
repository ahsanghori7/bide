<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientPrescriptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'remarks' => $this->consultation_note,
            'date' => $this->created_at,
            'follow_up_date' => Appointment::where('id', $this->appointment_id)->first()->follow_up_date,
            'prescribed_elements' => PrescribedElementResource::collection($this->whenLoaded('prescribedElements'))
        ];
    }
}
