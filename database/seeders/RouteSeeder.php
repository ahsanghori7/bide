<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
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
                'name' => 'Enteral Routes Of Medication',
                'status' => 1,

            ],
            [
                'name' => 'Oral',
                'status' => 1,

            ],
            [
                'name' => 'Intravenous Route',
                'status' => 1,

            ],

        ];

        foreach ($data as $routeData) {
            Route::create($routeData);
        }
    }
}
