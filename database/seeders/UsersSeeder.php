<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Doctor',
            'email' => 'doctor@merisehat.pk',
            'role_id' => 2,
            'organization_id' => 1,
            'clinic_user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Educator',
            'email' => 'educator@merisehat.pk',
            'role_id' => 3,
            'organization_id' => 1,
            'clinic_user_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('doctor_details')->insert(
            [
                'doctor_id' => 1,
                'prefix' => 'Dr.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('doctor_config')->insert(
            [
                'doctor_id' => 1,
                'daily_limit' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
