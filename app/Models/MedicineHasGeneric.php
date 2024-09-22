<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineHasGeneric extends Model
{
    public function medicine()
    {
        return $this->hasOne(Medicine::class, 'id', 'medicine_id');
    }

    public function generic()
    {
        return $this->hasOne(Generic::class, 'id', 'generic_id');
    }
}
