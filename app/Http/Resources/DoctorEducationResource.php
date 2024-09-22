<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorEducationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'degree' => $this->degree,
            'institute' => $this->institute,
            'year_of_completion' => $this->year_of_completion,
        ];
    }
}
