<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        $dob = new DateTime($this->date_of_birth);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dob)->y;

        return [
            'patient_id' => $this->id,
            'name' => $this->name,
            'mr_no' => $this->mr_no,
            'gender' => $this->gender,
            'site' => $this->work_address,
            'number' => $this->mobile_number,
            'age' => $age,
            'ethnicity' => $this->ethnicity,
            'last_visit' => $this->lastVisit ? $this->lastVisit->date : null,
            'registration_date' => $this->created_at,
            'cnic' => $this->cnic,
            'address' => $this->address,
            'work_address' => $this->work_address,
            'date_of_birth' =>  \Carbon\Carbon::parse($this->date_of_birth)->format('d/m/Y'),
            'email' => $this->email,
            'telephone' => $this->telephone,
            'patient_type' => Appointment::where('patient_id', $this->id)->count() > 1 ? 'Returning Patient' : "New Patient",
        ];
    }
}
