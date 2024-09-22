<?php

// File: database/seeders/MealTimeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed meal_time table with sample data
        $mealTimes = [
            ['name' => 'Breakfast'],
            ['name' => 'Mid Day Meal'],
            ['name' => 'Lunch'],
            ['name' => 'Tea Time'],
            ['name' => 'Dinner'],
            ['name' => 'Bed Time'],
            // Add more meal times as needed
        ];

        DB::table('meal_time')->insert($mealTimes);
    }
}
