<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'user1@dev.com',
            'name' => 'User1',
            'password' => bcrypt('123'),
            'type' => 'user',
            'photo' => 'profile.png',
            'social_reason' => 'Empresa de prueba 1',
            'ruc' => '20552103816',
            'adress' => 'Av.Pacto Andino 371, Villa el Salvador,Lima',
            'phone1' => '99999',
            // 'phone2' => '',
            'public_email' => 'mail@gmail.com',
            'web' => 'www.nombre.com.pe',
            'description' => 'Comercializacion de accesorios para vehículos',
        ]);
        User::create([
            'email' => 'user2@dev.com',
            'name' => 'User2',
            'password' => bcrypt('123'),
            'type' => 'user',
            'photo' => 'profile.png',
            'social_reason' => 'Empresa de prueba 1',
            'ruc' => '20552103816',
            'adress' => 'Av.Pacto Andino 371, Villa el Salvador,Lima',
            'phone1' => '99999',
            // 'phone2' => '',
            'public_email' => 'mail@gmail.com',
            'web' => 'www.nombre.com.pe',
            'description' => 'Comercializacion de accesorios para vehículos',

        ]);
        User::create([
            'email' => 'admin@dev.com',
            'name' => 'Admin',
            'password' => bcrypt('123'),
            'type' => 'admin',
            'photo' => 'profile.png',
        ]);
        User::create([
            'email' => 'accountant@dev.com',
            'name' => 'Accountant',
            'password' => bcrypt('123'),
            'type' => 'accountant',
            'photo' => 'profile.png',
        ]);

    }
}
