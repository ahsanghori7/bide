<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietaryAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'meal_entries_id',
        'fats_intake',
        'calories_intake',
        'calories_required',
        'calories_advised',
        'activity_factor',
        'injury_factor',
        'compliance',
        'visit_no',
        'cal_advised',
        'protein_intake',
        'sodium_intake',
        'remarks',
        'bmi',
        'ibw',
        'bee'
    ];

    // Define the relationship with PatientInfo
    public function patientInfo()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }


    public function mealEntries()
    {
        return $this->hasMany(MealEntry::class);
    }


    public function appoitment()
    {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }
}
