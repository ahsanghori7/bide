<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecialities extends Model
{
    public function speciality()
    {
        return $this->belongsTo(Specialities::class, 'speciality_id');
    }
}
