<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clinics')->insert([
            'name' => 'BIDE',
            'location' => 'karachi',
            'phone_number' => '0000000000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
