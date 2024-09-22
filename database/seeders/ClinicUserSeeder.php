<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clinic_user')->insert([
            'user_id' => 1,
            'clinic_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clinic_user')->insert([
            'user_id' => 2,
            'clinic_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
