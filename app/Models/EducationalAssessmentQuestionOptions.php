<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalAssessmentQuestionOptions extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'question_options';
    protected $with = ['children'];

    protected $fillable = [
        'question_id',
        'type',
        'option',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
