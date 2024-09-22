<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class InsulinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insulinNames = [
            'Lispro (Humalog)',
            'Aspart (NovoLog)',
            'Glulisine (Apidra)',
            'Regular insulin (R)',
            'NPH insulin (N)',
            'Glargine (Lantus, Toujeo)',
            'Detemir (Levemir)',
            'Degludec (Tresiba)',
            'Humalog Mix (Humalog 75/25, Humalog 50/50)',
            'NovoLog Mix (NovoLog 70/30)',
            'Ryzodeg (70/30 mix of degludec and aspart)',
            'Degludec (Tresiba)',
            'Glargine U300 (Toujeo)',
        ];

        foreach ($insulinNames as $name) {
            DB::table('insulin')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
