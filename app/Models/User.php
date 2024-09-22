<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'otp',
        'otp_expire',
        'is_login',
        'last_login',
        'in_call'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCurrentStatus()
    {
        if ($this->is_login == 1 && $this->in_call == 1) {
            return 'in-call';
        } elseif ($this->is_login == 1 && $this->in_call == 0) {
            return 'online';
        }
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_user', 'user_id', 'clinic_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function config()
    {
        return $this->hasOne(DoctorConfig::class, 'doctor_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, "doctor_id");
    }

    public function doctorEducations()
    {
        return $this->hasMany(DoctorEducations::class, "doctor_id")->with(['degree', 'institute']);
    }

    public function doctorExpriences()
    {
        return $this->hasMany(DoctorExperiences::class, "doctor_id")->with(['institute']);
    }

    public function doctorSpecialities()
    {
        return $this->hasMany(DoctorSpecialities::class, "doctor_id")->with(['speciality']);
    }

    public function doctorDetails()
    {
        return $this->hasOne(DoctorDetails::class, 'doctor_id', 'id');
    }

    public function getClinicNames()
    {
        return $this->clinics()->pluck('name');
    }

    public function getClinicName()
    {
        return $this->clinics()->pluck('name')->first();
    }
}
