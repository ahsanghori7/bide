<?php

namespace App\Models;

use App\Http\Common\Constant;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ActiveScope;
use Carbon\Carbon;

class Patient extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    protected $table = "patient_info";

    protected $fillable = [
        'mr_no',
        'name',
        'gender',
        'date_of_birth',
        'cnic',
        'mobile_number',
        'telephone',
        'address',
        'work_address',
        'ethnicity',
        'email',
        'status',
        'clinic_user_id'
    ];

    public function lastVisit()
    {
        return $this->hasOne(Appointment::class, 'patient_id')
            ->where('status', Constant::APPOINTMENT_STATUS_COMPLETED)->orderby('date', 'desc')->take(1);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function ethnicity($value)
    {
        return Ethnicities::where('id', $value)->first()->name;
    }
}
