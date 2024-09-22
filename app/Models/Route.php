<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $table = "medicine_routes";

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope());
    }
}
