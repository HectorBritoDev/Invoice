<?php

use App\ClientContact;
use Illuminate\Database\Seeder;

class ClientContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientContact::create(['client_id' => 1,
            'client_contact_name' => 'Pedro Perez',
            'client_contact_cellphone' => '11223344',
            'client_contact_phone' => '11223344',
            'client_contact_anexo' => '111',
            'client_contact_email' => 'pedro@cliente.com',
            'client_contact_charge' => 'Gerente',
            'client_contact_birthday' => today(),
            'client_contact_responsableFor' => 'Compras',
        ]);
        ClientContact::create(['client_id' => 2,
            'client_contact_name' => 'Juan Rojas',
            'client_contact_cellphone' => '11223344',
            'client_contact_phone' => '11223344',
            'client_contact_anexo' => '111',
            'client_contact_email' => 'juan@cliente.com',
            'client_contact_charge' => 'Supervisor',
            'client_contact_birthday' => today(),
            'client_contact_responsableFor' => 'Logistica',
        ]);
    }
}
