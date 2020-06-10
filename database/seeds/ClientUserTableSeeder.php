<?php

use App\ClientUser;
use Illuminate\Database\Seeder;

class ClientUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientUser::create(['user_id' => 1, 'client_id' => 1]);
        ClientUser::create(['user_id' => 2, 'client_id' => 2]);
    }
}
