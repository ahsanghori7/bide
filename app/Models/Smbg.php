<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Smbg extends Model
{
    protected $fillable = [
        'patient_id',
        'pre_breakfast',
        'post_breakfast',
        'pre_lunch',
        'post_lunch',
        'pre_dinner',
        'post_dinner',
        'before_bed',
        'random',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
