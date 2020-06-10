<?php

use App\GoodDetail;
use Illuminate\Database\Seeder;

class GoodDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodDetail::create([
            'good_id' => 1,

            //'measure' => 'Lts',
            // 'brand' => 'Venoco',
            // 'model' => '20-50',
            // 'serie' => 'Mineral',
            // 'badge' => 'Prueba',
            // 'color' => 'Gris',
            // 'size' => '5',
        ]);
        GoodDetail::create([
            'good_id' => 2,
            'measure' => 'Lts',
            'brand' => 'Venoco',
            'model' => '40-50',
            'serie' => 'Mineral',
            'badge' => 'Prueba',
            'color' => 'Gris',
            'size' => '5',
        ]);
        GoodDetail::create([
            'good_id' => 3,
            'measure' => 'cm',
            'brand' => 'Bellota',
            'model' => 'Cuadrada',
            'serie' => 'Premium',
            'badge' => 'Prueba',
            'color' => 'Negro',
            'size' => '30',
        ]);
        GoodDetail::create([
            'good_id' => 4,
            'measure' => 'cm',
            'brand' => 'Soil',
            'model' => 'Curva',
            'serie' => 'Clasica',
            'badge' => 'Prueba',
            'color' => 'Madera',
            'size' => '30',
        ]);
        GoodDetail::create([
            'good_id' => 5,
            'measure' => 'Kg',
            'brand' => 'Marta',
            'model' => 'Trigo',
            'serie' => 'Clasica',
            'badge' => 'Prueba',
            'color' => 'Amarilla',
            'size' => '50',
        ]);
        GoodDetail::create([
            'good_id' => 6,
            'measure' => 'Kg',
            'brand' => 'Marta',
            'model' => 'Maiz',
            'serie' => 'Clasica',
            'badge' => 'Prueba',
            'color' => 'Blanca',
            'size' => '60',
        ]);
        GoodDetail::create([
            'good_id' => 7,
            'measure' => '$',
            'brand' => 'Prestamo',
            'model' => '',
            'serie' => 'Largo plazo',
            'badge' => 'Prueba',
            'color' => '',
            'size' => '50',
        ]);
        GoodDetail::create([
            'good_id' => 8,
            'measure' => '$',
            'brand' => 'Prestamo',
            'model' => '',
            'serie' => 'Reestructura',
            'badge' => 'Prueba',
            'color' => '',
            'size' => '50',
        ]);
    }
}
