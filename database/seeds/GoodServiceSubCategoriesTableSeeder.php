<?php

use App\GoodServiceSubCategory;
use Illuminate\Database\Seeder;

class GoodServiceSubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoodServiceSubCategory::create(['category_id' => 1, 'name' => 'Gasoi']);
        GoodServiceSubCategory::create(['category_id' => 1, 'name' => 'Gasolina']);
        GoodServiceSubCategory::create(['category_id' => 2, 'name' => 'Pico']);
        GoodServiceSubCategory::create(['category_id' => 2, 'name' => 'Pala']);
        GoodServiceSubCategory::create(['category_id' => 3, 'name' => 'Harina']);
        GoodServiceSubCategory::create(['category_id' => 3, 'name' => 'Pimienta']);
        GoodServiceSubCategory::create(['category_id' => 4, 'name' => 'Construccion de casa']);
        GoodServiceSubCategory::create(['category_id' => 4, 'name' => 'Prestamo']);

    }
}
