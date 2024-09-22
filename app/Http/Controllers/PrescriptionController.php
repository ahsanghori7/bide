<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenericsResource;
use App\Http\Resources\InsulinResource;
use App\Http\Resources\InsulinUnitResource;
use App\Http\Resources\PrescriptionResource;
use App\Models\Medicine;
use App\Models\MedicineType;
use App\Models\Insulin;
use App\Models\InsulinUnit;
use App\Models\Labs;
use App\Models\MedicineHasGeneric;
use App\Models\Route;
use App\Models\Strength;

class PrescriptionController extends Controller
{
    public function getMedicineTabInfo()
    {
        $medicines = Medicine::all();
        $medicine_types = MedicineType::all();
        $strengths = Strength::all();
        $routes = Route::all();

        $meds = PrescriptionResource::collection($medicines);
        $med_type = PrescriptionResource::collection($medicine_types);
        $strengths = PrescriptionResource::collection($strengths);
        $routes = PrescriptionResource::collection($routes);

        return [
            'medicines' => $meds,
            'medicine_type' => $med_type,
            'strengths' => $strengths,
            'routes' => $routes
        ];
    }

    public function getInsulinTabInfo()
    {
        $insulin = Insulin::all();
        $insulinUnit = InsulinUnit::all();

        $insulin_collection = InsulinResource::collection($insulin);
        $insulinUnit = InsulinUnitResource::collection($insulinUnit);

        return [
            'insulin' => $insulin_collection,
            'insulinUnit' => $insulinUnit
        ];
    }

    public function getLabTestInfo()
    {
        $labs = Labs::all();

        return PrescriptionResource::collection($labs);
    }

    public function getMedicineGenerics($id)
    {
        $generics = MedicineHasGeneric::with('generic')->where('medicine_id', $id)->first();
        $generics =  new GenericsResource($generics);

        return
            $generics->toArray(null);

    }

}
