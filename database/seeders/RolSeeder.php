<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Insert roles for default */ 
        DB::table('roles')->insert([
            [
                'name' => 'Administrador',
                'description' => 'Control total.'
            ],
            [
                'name' => 'Invitado',
                'description' => 'Visualización por permisos.'
            ],
        ]);
        
    }
}
