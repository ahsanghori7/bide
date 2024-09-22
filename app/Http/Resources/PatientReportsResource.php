<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PatientReportsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'lab_name' => $this->lab_name,
            'date' => $this->date ? Carbon::parse($this->date)->format('d/m/y') : null,
            'fbs' => $this->fbs ?? '00',
            'rbs' => $this->rbs ?? '00',
            'hba1c' => $this->hba1c ?? '00',
            's_creatinine' => $this->s_creatinine ?? '00',
            'urine_dr' => $this->urine_dr ?? '00',
            'microalbumin' => $this->microalbumin ?? '00',
            'tfh_u_protein' => $this->tfh_u_protein ?? '00',
            'tfh_cct' => $this->tfh_cct ?? '00',
            'total_lipid' => $this->total_lipid ?? '00',
            'cholesterol' => $this->cholesterol ?? '00',
            'triglyceride' => $this->triglyceride ?? '00',
            'ldl' => $this->ldl ?? '00',
            'hdl' => $this->hdl ?? '00',
            'ecg' => $this->ecg ?? '00',
            'ett' => $this->ett ?? '00',
            'echo' => $this->echo ?? '00',
            't3' => $this->t3 ?? '00',
            't4' => $this->t4 ?? '00',
            'tsh' => $this->tsh ?? '00',
            'cds' => $this->cds ?? '00',
            'glucose' => $this->glucose ?? '00',
            'hbs' => $this->hbs ?? '00',
            'xray_chest' => $this->xray_chest ?? '00',
            'remarks' => $this->remarks ?? '00',
            'alb' => $this->alb ?? '00',
            'hup' => $this->hup ?? '00'
        ];
    }
}
