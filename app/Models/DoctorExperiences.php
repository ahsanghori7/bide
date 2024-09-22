<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorExperiences extends Model
{
    public function institute()
    {
        return $this->belongsTo(Universities::class, 'institute');
    }
}
