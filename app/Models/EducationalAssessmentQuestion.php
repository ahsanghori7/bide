<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalAssessmentQuestion extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'section',
        'question',
    ];

    public function options()
    {
        return $this->hasMany(EducationalAssessmentQuestionOptions::class, 'question_id');
    }
}
