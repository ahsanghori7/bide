<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientMedicalHistoryResourceForAppointment extends JsonResource
{
    public function toArray($request)
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'patient_id' => $this->patient_id,
                'medical_history' => [
                    [
                        'Question' => 'Previous Treat',
                        'Answer' => $this->previous_treat,
                        'Response' => $this->previous_treat_text,
                    ],
                    [
                        'Question' => 'Eye Drop',
                        'Answer' => $this->eye_drop,
                        'Response' => $this->eye_drop_text,
                    ],
                    [
                        'Question' => 'Walk',
                        'Answer' => $this->walk,
                    ],
                    [
                        'Question' => 'Previous Medication',
                        'Answer' => $this->previous_medication,
                        'Response' => $this->previous_medication_text,
                    ]
                ],
                'date' => $this->created_at,
            ];
        } else {
            return [];
        }
    }
}
