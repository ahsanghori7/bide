<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MedicineTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicineTypes = [
            'Tablet',
            'Capsule',
            'Syrup',
            'Injection',
            'Cream',
            'Ointment',
            'Drops',
            'Inhaler',
            'Powder',
            'Suspension',
            'Gel',
            'Lotion',
            'Lozenge',
            'Patch',
            'Suppository',
            'Nasal Spray',
            'Solution',
            'Chewable Tablet',
            'Sublingual Tablet',
            'Effervescent Tablet',
            'Pessary',
            'Liniment',
            'Emulsion',
            'Mouthwash',
            'Eye Drops',
            'Ear Drops',
            'Oral Paste',
            'Powder for Injection',
            'Implant',
        ];

        foreach ($medicineTypes as $type) {
            DB::table('medicine_types')->insert(['name' => $type]);
        }
    }
}
