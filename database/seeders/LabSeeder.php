<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class LabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $LabNames = [
            'Essa Lab North Nazimabad',
            'Essa Lab Gulshan e Iqbal',
        ];

        foreach ($LabNames as $name) {
            DB::table('labs')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
