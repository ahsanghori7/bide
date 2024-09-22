<?php

namespace App\Http\Controllers;

use App\Http\Resources\AvailableDoctorResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use App\Services\DoctorService;

class DoctorController extends Controller
{
    private $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function doctorListing(Request $request)
    {
        $doctors = $this->doctorService->availableDoctor($request);
        if ($doctors) {
            return AvailableDoctorResource::collection($doctors);
        } else {
            return ApiResponse::error(trans('errors.doctor_not_available'), 404);
        }
    }
}
