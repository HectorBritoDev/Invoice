<?php

use App\GoodPrice;
use Illuminate\Database\Seeder;

class GoodPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodPrice::create([
            'good_id' => 1,
            'wholesale_price' => 80,
            'unit_price' => 100,
            'tax' => 10,
        ]);
        GoodPrice::create([
            'good_id' => 2,
            'wholesale_price' => 100,
            'unit_price' => 150,
            'tax' => 40,
        ]);
        GoodPrice::create([
            'good_id' => 3,
            'wholesale_price' => 100,
            'unit_price' => 150,
            'tax' => 20,
        ]);
        GoodPrice::create([
            'good_id' => 4,
            'wholesale_price' => 100,
            'unit_price' => 150,
            'tax' => 20,
        ]);
        GoodPrice::create([
            'good_id' => 5,
            'wholesale_price' => 100,
            'unit_price' => 150,
            'tax' => 20,
        ]);
        GoodPrice::create([
            'good_id' => 6,
            'wholesale_price' => 1000,
            'unit_price' => 1500,
            'tax' => 200,
        ]);
        GoodPrice::create([
            'good_id' => 7,
            'wholesale_price' => 1000,
            'unit_price' => 1500,
            'tax' => 200,
        ]);
        GoodPrice::create([
            'good_id' => 8,
            'wholesale_price' => 1000,
            'unit_price' => 1500,
            'tax' => 200,
        ]);
    }
}
