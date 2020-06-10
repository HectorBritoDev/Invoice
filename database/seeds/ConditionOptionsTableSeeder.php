<?php

use App\ConditionOption;
use Illuminate\Database\Seeder;

class ConditionOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConditionOption::create(['code' => '1', 'name' => 'Al contado']);
        ConditionOption::create(['code' => '2', 'name' => 'Contra entrega']);
        ConditionOption::create(['code' => '7', 'name' => 'Crédito a 7 días']);
        ConditionOption::create(['code' => '12', 'name' => 'Crédito a 12 días']);
        ConditionOption::create(['code' => '15', 'name' => 'Crédito a 15 días']);
        ConditionOption::create(['code' => '30', 'name' => 'Crédito a 30 días']);
        ConditionOption::create(['code' => '45', 'name' => 'Crédito a 45 días']);
        ConditionOption::create(['code' => '60', 'name' => 'Crédito a 60 días']);
        ConditionOption::create(['code' => '90', 'name' => 'Crédito a 90 días']);
    }
}
