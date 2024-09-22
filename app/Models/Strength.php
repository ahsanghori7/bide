<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Strength extends Model
{
    protected $table = "medicine_strengths";

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
