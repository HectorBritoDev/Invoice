<?php

use App\MeasureOption;
use Illuminate\Database\Seeder;

class MeasureOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MeasureOption::create(['code' => '1', 'name' => 'KILOGRAMOS']);
        MeasureOption::create(['code' => '2', 'name' => 'LIBRAS']);
        MeasureOption::create(['code' => '3', 'name' => 'TONELADAS LARGAS']);
        MeasureOption::create(['code' => '4', 'name' => 'TONELADAS MÉTRICAS']);
        MeasureOption::create(['code' => '5', 'name' => 'TONELADAS CORTAS']);
        MeasureOption::create(['code' => '6', 'name' => 'GRAMOS']);
        MeasureOption::create(['code' => '7', 'name' => 'UNIDADES']);
        MeasureOption::create(['code' => '8', 'name' => 'LITROS']);
        MeasureOption::create(['code' => '9', 'name' => 'GALONES']);
        MeasureOption::create(['code' => '10', 'name' => 'BARRILES']);
        MeasureOption::create(['code' => '11', 'name' => 'LATAS']);
        MeasureOption::create(['code' => '12', 'name' => 'CAJAS']);
        MeasureOption::create(['code' => '13', 'name' => 'MILLARES']);
        MeasureOption::create(['code' => '14', 'name' => 'METROS CÚBICOS']);
        MeasureOption::create(['code' => '15', 'name' => 'METROS']);

    }
}
