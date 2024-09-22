<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PatientDiabetesHistory extends Model
{
    protected $table = "diabetes_history";

    protected $fillable = [
        'patient_id',
        'type',
        'year_diagnosed',
        'insulin',
        'insulin_details',
        'keto_diagnosis',
        'keto_details',
        'remarks',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
