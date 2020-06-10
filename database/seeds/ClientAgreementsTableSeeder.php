<?php

use App\ClientAgreement;
use Illuminate\Database\Seeder;

class ClientAgreementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientAgreement::create([
            'client_id' => 1,
            'conditions' => '1',
            'credit_line' => '1',
            'pay_method' => '1',
        ]);
        ClientAgreement::create([
            'client_id' => 2,
            'conditions' => '2',
            'credit_line' => '2',
            'pay_method' => '2',
        ]);
    }
}
