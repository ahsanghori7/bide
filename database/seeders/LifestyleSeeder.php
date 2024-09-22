<?php

namespace Database\Seeders;

use App\Models\Lifestyle;
use Illuminate\Database\Seeder;

class LifestyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lifestyles = [
            ['name' => 'None', 'status' => true],
            ['name' => 'Smoker', 'status' => true],
            ['name' => 'Alcholic', 'status' => true],
            ['name' => 'Both', 'status' => true],
            ['name' => 'Other', 'status' => true],
        ];

        foreach ($lifestyles as $lifestyle) {
            Lifestyle::create($lifestyle);
        }
    }
}
