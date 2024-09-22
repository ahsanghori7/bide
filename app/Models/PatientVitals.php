<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVitals extends Model
{
    protected $table = "vitals";

    protected $casts = [
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'glucometer_result' => 'decimal:2',
        'temperature' => 'decimal:2',
        'bmi' => 'decimal:2',
        'blood_pressure_diastolic' => 'decimal:2',
        'blood_pressure_systolic' => 'decimal:2',
        'heart_rate' => 'decimal:2',
    ];

    protected $fillable = [
        'patient_id',
        'heart_rate',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'bmi',
        'temperature',
        'glucometer_result',
        'height',
        'weight'
    ];
}
