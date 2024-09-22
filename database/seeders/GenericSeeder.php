<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Generic;

class GenericSeeder extends Seeder
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
                'name' => 'Safe',
                'status' => 1,

            ],
            [
                'name' => 'Effective',
                'status' => 1,

            ],
            [
                'name' => 'High-Quality',
                'status' => 1,

            ],

        ];

        foreach ($data as $genericData) {
            Generic::create($genericData);
        }
    }
}
