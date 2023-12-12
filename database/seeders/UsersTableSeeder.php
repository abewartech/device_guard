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
                'name' => 'admin',
                'email' => 'admin@database.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$aMakfX.7DNikKkYyeaOW7.wl7Y.3u4QVto8DxUarXC5pcmxNdPB7K',
                'remember_token' => '5jNXe8qNGF0C1mvyQ4H0IfklpqqYYUkpdGoBWpsSxSF6tvBuTv6T5ubDhMre',
                'created_at' => '2023-12-12 04:13:00',
                'updated_at' => '2023-12-12 04:13:00',
            ),
        ));
        
        
    }
}