<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for meal_entries table
        $mealEntriesData = [
            [
                'meal_time_id' => 1,
                'cereal' => 100,
                'vegetable' => 150,
                'meat' => 200,
                'milk' => 50,
                'fruits' => 120,
                'fats' => 30,
                'calories' => 800,
                'carbo' => 120,
                'protein' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more entries as needed
        ];

        // Insert data into meal_entries table
        DB::table('meal_entries')->insert($mealEntriesData);

    }
}
