<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'token',
        'appointment_id',
        'doctor_id',
        'appointment_date'
    ];

    public function getTokenAttribute($value)
    {
        return str_pad($value, 2, '0', STR_PAD_LEFT);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
