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
                'email' => 'adminblog@gmail.com',
                'password' => bcrypt('adminBlog'),
                'avatar_admin' => NULL,

            ]
        ]);
    }
}
