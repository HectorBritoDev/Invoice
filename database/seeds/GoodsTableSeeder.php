<?php

use App\Good;
use Illuminate\Database\Seeder;

class GoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Good::create([
            'user_id' => 1,
            'category_id' => 1,
            'type' => 'good',
            'name' => 'Aceite 20-50',
            'code' => 'A11111',
            'reference' => 'A20',
        ]);
        Good::create([
            'user_id' => 1,
            'category_id' => 1,
            'type' => 'good',
            'name' => 'Aceite 40-50',
            'code' => 'A2222',
            'reference' => 'A40',
        ]);
        Good::create([
            'user_id' => 1,
            'category_id' => 2,
            'type' => 'good',
            'name' => 'Pala curva',
            'code' => 'P1111',
            'reference' => 'PC',
        ]);
        Good::create([
            'user_id' => 1,
            'category_id' => 2,
            'type' => 'good',
            'name' => 'Pala Recta',
            'code' => 'P2222',
            'reference' => 'PR',
        ]);
        Good::create([
            'user_id' => 1,
            'category_id' => 3,
            'type' => 'service',
            'name' => 'Harina Trigo',
            'code' => 'H1111',
            'reference' => 'HT',
        ]);
        Good::create([
            'user_id' => 1,
            'category_id' => 3,
            'type' => 'service',
            'name' => 'Harina Maiz',
            'code' => 'H2222',
            'reference' => 'HM',
        ]);
        Good::create([
            'user_id' => 2,
            'category_id' => 4,
            'type' => 'service',
            'name' => 'Prestamo casa',
            'code' => 'PC1111',
            'reference' => 'PCL',
        ]);
        Good::create([
            'user_id' => 2,
            'category_id' => 4,
            'type' => 'service',
            'name' => 'Reconstrucción',
            'code' => 'R1111',
            'reference' => 'R',
        ]);

    }
}
