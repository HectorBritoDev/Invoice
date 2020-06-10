<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'user_id' => 1,
            'client_name' => 'Cliente de Prueba 1, C.A',
            'client_email' => 'cliente@cliente.com',
            'client_main_adress' => 'Miami',
            'ruc' => '1122334455',
            'client_cellphone' => '4148068840',
            'sunat_situation' => 'HABIDO']);
        Client::create([
            'user_id' => 2,
            'client_name' => 'Cliente de Prueba 2, C.A',
            'client_email' => 'cliente@cliente.com',
            'client_main_adress' => 'New York',
            'ruc' => '1122334455',
            'client_cellphone' => '4148068840',
            'sunat_situation' => 'HABIDO']);

    }
}
