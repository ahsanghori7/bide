<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealEntry extends Model
{
    protected $fillable = [
        'meal_time_id',
        'cereal',
        'vegetable',
        'meat',
        'milk',
        'fruits',
        'fats',
        'calories',
        'carbo',
        'protein',
        'dietary_assessment_id',
        'cereal_misc',
        'fats_misc',
        'calories_misc'
    ];

    // MealEntry model
    public function dietaryAssessments()
    {
        return $this->belongsToMany(DietaryAssessment::class, 'dietary_assessment_meal_entry');
    }

    public function mealTime()
    {
        return $this->belongsTo(MealTime::class);
    }
}
