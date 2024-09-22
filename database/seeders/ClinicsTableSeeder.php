<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Clinic;

class ClinicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Clinic::create([
                'name' => $faker->company,
                'location' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                // Add other fields as needed
            ]);
        }
    }
}
