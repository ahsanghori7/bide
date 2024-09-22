<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientSmbgResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'pre_breakfast' => $this->pre_breakfast ?? '00',
            'post_breakfast' => $this->post_breakfast ?? '00',
            'pre_lunch' => $this->pre_lunch ?? '00',
            'post_lunch' => $this->post_lunch ?? '00',
            'pre_dinner' => $this->pre_dinner ?? '00',
            'post_dinner' => $this->post_dinner ?? '00',
            'before_bed' => $this->before_bed ?? '00',
            'random' => $this->random ?? '00',
            'date' => $this->created_at
        ];
    }
}
