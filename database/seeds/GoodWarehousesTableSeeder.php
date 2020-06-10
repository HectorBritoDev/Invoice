<?php

use App\GoodWarehouse;
use Illuminate\Database\Seeder;

class GoodWarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodWarehouse::create([
            'good_id' => 1,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 2,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 3,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 4,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 5,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 6,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 7,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
        GoodWarehouse::create([
            'good_id' => 8,
            'name' => 'Principal',
            'adress' => 'Florida',
        ]);
    }
}
