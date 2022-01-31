<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Insert user admin **/
        DB::table('users')->insert([
            [
                'name' => 'Administrador Blog',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin1'),
                'rol_id' => 1,
                'avatar_admin' => NULL,

            ],
            [
                'name' => 'Invitado Blog',
                'email' => 'invitado@gmail.com',
                'password' => bcrypt('invitado2'),
                'rol_id' => 2,
                'avatar_admin' => NULL,

            ]
        ]);
    }
}
