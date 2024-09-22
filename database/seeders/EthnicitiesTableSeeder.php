<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EthnicitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ethnicities = [
            ['name' => 'Asian', 'status' => true],
            ['name' => 'African', 'status' => true],
            ['name' => 'European', 'status' => true],
            ['name' => 'Caucasian', 'status' => true],
            ['name' => 'Other', 'status' => true],

        ];

        DB::table('ethnicities')->insert($ethnicities);
    }
}
