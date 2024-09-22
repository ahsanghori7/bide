<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->doctorDetails->prefix . " " . $this->name,
            'role_id' => $this->role->id,
            'role_name' => $this->role->name,
            'organization' => $this->organization->name,
            'clinic_name' => $this->clinics[0]->name,
            'is_featured' => $this->doctorDetails->is_featured,
            'experience_year' => $this->doctorDetails->experience_year,
            'image' => $this->doctorDetails->image,
            'doctor_educations' => DoctorEducationResource::collection($this->doctorEducations),
            'doctor_expriences' => DoctorExperienceResource::collection($this->doctorExpriences),
            'doctor_specialities' => DoctorSpecialityResource::collection($this->doctorSpecialities),
        ];
    }
}
