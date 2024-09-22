<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
