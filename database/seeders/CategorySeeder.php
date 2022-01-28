<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          /** Insert categories for default **/
          DB::table('categories')->insert([
            [
                'name' => 'Tecnología',
                'description' => 'Variedades en equipos de tecnología del momento.',
            ],
            [
                'name' => 'Automóviles',
                'description' => 'Variedades en vehiculos automotores nuevos.',
            ],
            [
                'name' => 'Cultura y Arte',
                'description' => 'Variedades en cuadros y libros para nutrir el conocimiento.',
            ]
        ]);
    }
}
