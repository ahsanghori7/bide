<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPersonalHistory extends Model
{
    protected $table = "patient_personal_history";

    protected $fillable = [
        'patient_id',
        'marital_status',
        'occupation',
        'lifestyle',
        'father_diabetic',
        'father_diabetic_text',
        'mother_diabetic',
        'mother_diabetic_text',
        'spouse_diabetic',
        'spouse_diabetic_text',
        'brother_diabetic',
        'brother_diabetic_text',
        'sister_diabetic',
        'sister_diabetic_text',
        'children_diabetic',
        'children_diabetic_text',
        'live_birth',
        'live_birth_text',
        'still_birth',
        'still_birth_text',
        'neonatal_deaths',
        'neonatal_deaths_text',
        'abortion',
        'abortiont_ext',
    ];
}
