<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role_id' => $this->role->id,
            'role_name' => $this->role->name,
            'organization' => $this->organization->name,
            'clinic_name' => $request->user()->getClinicName(),
            'is_featured' => true
        ];
    }
}
