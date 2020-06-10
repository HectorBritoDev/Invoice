<?php

use App\ClientDebt;
use Illuminate\Database\Seeder;

class ClientDebtsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientDebt::create([
            'client_id' => 1,
            'document_type' => 'Fiscal',
            'document_number' => '222222',
            'document_emission' => today(),
            'document_expiration' => today(),
            'debt' => '10000',
            'file' => 'prueba',
            'file_title' => 'prueba',
        ]);
        ClientDebt::create([
            'client_id' => 2,
            'document_type' => 'Fiscal',
            'document_number' => '3333',
            'document_emission' => today(),
            'document_expiration' => today(),
            'debt' => '20000',
            'file' => 'prueba',
            'file_title' => 'prueba',
        ]);
    }
}
