<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Strength;

class StrengthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Pain relievers',
                'status' => 1,

            ],
            [
                'name' => 'Sedatives',
                'status' => 1,

            ],
            [
                'name' => 'Stimulants',
                'status' => 1,

            ],

        ];

        foreach ($data as $strengthData) {
            Strength::create($strengthData);
        }
    }
}
