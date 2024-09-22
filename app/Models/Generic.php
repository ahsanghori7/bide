<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Generic extends Model
{
    protected $table = "medicine_generics";

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
