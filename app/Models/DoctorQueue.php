<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorQueue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'clinic_user_id',
        'status',
        'patient_verified'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function educator()
    {
        return $this->belongsTo(User::class, 'clinic_user_id', 'clinic_user_id');
    }

    public function token()
    {
        return $this->belongsTo(Token::class, 'appointment_id', 'appointment_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id')->where('role_id', 2);
    }
}
