<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescribedElement extends Model
{
    use HasFactory;

    protected $table = 'prescribed_elements';
    protected $fillable = [
        'prescription_id', 'prescription_element_id', 'type',
        'generic_id', 'type_id', 'unit', 'route_id', 'item_strength_id',
        'duration_id', 'number_of_days', 'dosage', 'per_day', 'is_after_meal', 'is_before_meal',
        'morning', 'noon', 'evening', 'night'
    ];

    public function medicineGeneric()
    {
        return $this->belongsTo(Generic::class, 'generic_id');
    }

    public function medicineType()
    {
        return $this->belongsTo(MedicineType::class, 'type_id');
    }


    public function insulineUnit()
    {
        return $this->belongsTo(InsulinUnit::class, 'unit_id');
    }

    public function medicineRoute()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function lab()
    {
        return $this->belongsTo(Labs::class, 'prescription_element_id');
    }

    public function medicineItemStrength()
    {
        return $this->belongsTo(Strength::class, 'item_strength_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'prescription_element_id');
    }

    public function insulin()
    {
        return $this->belongsTo(Insulin::class, 'prescription_element_id');
    }

    public function getGenericNameAttribute()
    {
        return $this->medicineGeneric->name ?? null;
    }

    public function getTypeNameAttribute()
    {
        return $this->medicineType->name ?? null;
    }

    public function getUnitNameAttribute()
    {
        return $this->insulineUnit->unit ?? null;
    }

    public function getRouteNameAttribute()
    {
        return $this->medicineRoute->name ?? null;
    }

    public function getLabNameAttribute()
    {
        return $this->lab->name ?? null;
    }

    public function getItemStrenghtAttribute()
    {
        return $this->medicineItemStrength->name ?? null;
    }

    public function getMedicineNameAttribute()
    {
        return $this->medicine->name ?? null;
    }

    public function getInsulineNameAttribute()
    {
        return $this->insulin->name ?? null;
    }
}
