<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occupatios = [
            ['name' => 'Engineer', 'status' => true],
            ['name' => 'Doctor', 'status' => true],
            ['name' => 'Teacher', 'status' => true],
            ['name' => 'Student', 'status' => true],
            ['name' => 'Businessman', 'status' => true],
            ['name' => 'Private Job', 'status' => true],
            ['name' => 'Government Job', 'status' => true],
            ['name' => 'Housewife', 'status' => true],
            ['name' => 'Daily Wages', 'status' => true],
            ['name' => 'Other', 'status' => true],
        ];

        foreach ($occupatios as $occupatio) {
            Occupation::create($occupatio);
        }
    }
}
