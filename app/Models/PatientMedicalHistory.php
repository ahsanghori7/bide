<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalHistory extends Model
{
    protected $table = "patient_medical_history";

    protected $fillable = [
        'patient_id',
        'previous_treat',
        'previous_treat_text',
        'eye_drop',
        'eye_drop_text',
        'walk',
        'previous_medication',
        'previous_medication_text',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
