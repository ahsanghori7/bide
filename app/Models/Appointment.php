<?php

namespace App\Models;

use App\Http\Common\Constant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'clinic_id',
        'date',
        'action_by',
        'user_id',
        'time',
        'is_doctor_connected',
        'agora_link',
        'cancelled_by',
        'type',
        'call_ended',
        'status',
        'is_patient_connected',
        'call_started',
        'completed_by',
        'follow_up_date',
        'clinic_user_id'
    ];

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function doctor()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id')->where('role_id', Constant::DOCTOR_ROLE_ID);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }
}
