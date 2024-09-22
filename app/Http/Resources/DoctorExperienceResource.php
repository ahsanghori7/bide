<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorExperienceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'position' => $this->position,
            'institute' => $this->institute,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
        ];
    }
}
