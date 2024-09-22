<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Educator;

class EducatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $educatorsData = [
            [
                'name' => 'Dr. Educator One',
                'qualification' => 'PhD in Education',
                'age' => 35,
                // Add other fields as needed
            ],
            [
                'name' => 'Prof. Educator Two',
                'qualification' => 'MEd, MA',
                'age' => 40,
                // Add other fields as needed
            ],
            // Add more educator data as needed
        ];

        foreach ($educatorsData as $educatorData) {
            Educator::create($educatorData);
        }
    }
}
