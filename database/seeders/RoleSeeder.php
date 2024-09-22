<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => 'admin',
            'translation' => 'en',
            'created_at' => now(),
            'updated_at' => now(),
            'parent_id' => null,
        ]);


        DB::table('roles')->insert([
            'name' => 'Doctor',
            'slug' => 'doctor',
            'translation' => 'en',
            'created_at' => now(),
            'updated_at' => now(),
            'parent_id' => null,
        ]);

        DB::table('roles')->insert([
            'name' => 'Educator',
            'slug' => 'educator',
            'translation' => 'en',
            'created_at' => now(),
            'updated_at' => now(),
            'parent_id' => null,
        ]);
    }
}
