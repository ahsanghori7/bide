<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WaitingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'queue_id' => $this->id,
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'mr_no' => $this->patient->mr_no,
            'gender' => $this->patient->gender,
            'date' => $this->patient->created_at,
            'time' => Carbon::parse(Carbon::parse($this->patient->getRawOriginal('created_at'))->format('Y-m-d H:i:s'))->format('H:i'),
            'educator' => $this->educator->name,
            'patient_no' => $this->patient->mobile_number
        ];
    }
}
