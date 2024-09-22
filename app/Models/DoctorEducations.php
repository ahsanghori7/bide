<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorEducations extends Model
{
    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree');
    }

    public function institute()
    {
        return $this->belongsTo(Universities::class, 'institute');
    }
}
