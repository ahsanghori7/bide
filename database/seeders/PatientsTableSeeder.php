<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Patient;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Patient::create([
                'name' => $faker->name,
                'cnic' => $faker->unique()->numerify('##########'),
                'mobile_number' => $faker->unique()->numerify('##########'),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'dob' => $faker->date,
                'address' => $faker->address,
                // Add other fields as needed
            ]);
        }
    }
}
