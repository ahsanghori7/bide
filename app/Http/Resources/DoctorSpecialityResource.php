<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorSpecialityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'speciality' => $this->speciality->name,
            'slug' => $this->speciality->slug,
        ];
    }
}
