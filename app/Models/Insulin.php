<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insulin extends Model
{
    use HasFactory;

    protected $table = 'insulin';

    protected $fillable = [
        'name',
    ];
}
