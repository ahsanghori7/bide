<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctorsData = [
            [
                'name' => 'Dr. John Doe',
                'hospital' => 'General Hospital',
                'qualifications' => 'MD, PhD',
                'age' => 40,
                // Add other fields as needed
            ],
            [
                'name' => 'Dr. Jane Smith',
                'hospital' => 'City Medical Center',
                'qualifications' => 'MBBS, MS',
                'age' => 35,
                // Add other fields as needed
            ],
            // Add more doctor data as needed
        ];

        foreach ($doctorsData as $doctorData) {
            Doctor::create($doctorData);
        }
    }
}
