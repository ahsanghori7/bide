<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalAssessment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'question_id',
        'element_id',
        'element_value',
        'answer',
        'patient_id',
        'appointment_id',
        'assessment_date'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function questions()
    {
        return $this->hasOne(EducationalAssessmentQuestion::class, 'id', 'question_id');
    }
}
