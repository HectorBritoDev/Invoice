<?php

use App\GoodName;
use Illuminate\Database\Seeder;

class GoodNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodName::create([
            'good_id' => 1,
            'other_name' => 'Aceite Carro',
            'other_code' => 'AC',
            'other_reference' => 'AC1111',
        ]);
        GoodName::create([
            'good_id' => 2,
            'other_name' => 'Aceite Mineral',
            'other_code' => 'AM',
            'other_reference' => 'AM1111',
        ]);
        GoodName::create([
            'good_id' => 3,
            'other_name' => 'Pala Roma',
            'other_code' => 'PR1111',
            'other_reference' => 'PR',
        ]);
        GoodName::create([
            'good_id' => 4,
            'other_name' => 'Pala Cuadrada',
            'other_code' => 'PalaC11',
            'other_reference' => 'PalaC',
        ]);
        GoodName::create([
            'good_id' => 5,
            'other_name' => 'Harina PAN',
            'other_code' => 'HP222',
            'other_reference' => 'HPAN',
        ]);
        GoodName::create([
            'good_id' => 6,
            'other_name' => 'Harina Trigolar',
            'other_code' => 'HT333',
            'other_reference' => 'HTri',
        ]);
        GoodName::create([
            'good_id' => 7,
            'other_name' => 'House Loan',
            'other_code' => 'HL333',
            'other_reference' => 'HLO',
        ]);
        GoodName::create([
            'good_id' => 7,
            'other_name' => 'Reestructure',
            'other_code' => 'R333',
            'other_reference' => 'Rstruc',
        ]);
    }
}
