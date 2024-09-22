<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabReport extends Model
{
    protected $fillable = [
        'patient_id',
        'fbs',
        'rbs',
        'hba1c',
        's_creatinine',
        'urine_dr',
        'microalbumin',
        'tfh_u_protein',
        'tfh_cct',
        'total_lipid',
        'cholesterol',
        'triglyceride',
        'ldl',
        'hdl',
        'ecg',
        'ett',
        'echo',
        't3',
        't4',
        'tsh',
        'cds',
        'glucose',
        'hbs',
        'xray_chest',
        'remarks',
        'lab_name',
        'date',
        'hup',
        'alb'
    ];
}
