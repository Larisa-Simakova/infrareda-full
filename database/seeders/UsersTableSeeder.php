<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'login' => 'admin',
                'password' => '$2y$12$D8PEL4J9VZ/D6uaIisrdL.C6/mkd.qz0M3tB1dADu4fKlUgx4L/hu',
                'role' => 'admin',
                'remember_token' => NULL,
                'created_at' => '2025-05-21 08:44:54',
                'updated_at' => '2025-05-21 08:44:54',
            ),
        ));
        
        
    }
}