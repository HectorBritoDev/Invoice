<?php

use App\GoodServiceCategory;
use Illuminate\Database\Seeder;

class GoodServiceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodServiceCategory::create(['user_id' => 1, 'name' => 'Mercadería']);
        GoodServiceCategory::create(['user_id' => 1, 'name' => 'Producto Terminado']);
        GoodServiceCategory::create(['user_id' => 1, 'name' => 'Materias primas y auxiliares - Materiales']);
        GoodServiceCategory::create(['user_id' => 1, 'name' => 'Suministros diversos']);
        GoodServiceCategory::create(['user_id' => 2, 'name' => 'Suministros diversos']);
    }
}
