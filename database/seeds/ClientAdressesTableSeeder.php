<?php

use App\ClientAdress;
use Illuminate\Database\Seeder;

class ClientAdressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientAdress::create(['client_id' => 1,
            'client_adress' => 'Calle Miranda LIMA-LIMA-LIMA',
            'department_id' => 1,
            'province_id' => 2,
            'district_id' => 3]);

        ClientAdress::create(['client_id' => 2,
            'client_adress' => 'Calle Miranda LIMA-LIMA-LIMA',
            'department_id' => 3,
            'province_id' => 2,
            'district_id' => 1]);
    }
}
