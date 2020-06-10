<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(ClientAdressesTableSeeder::class);
        $this->call(ClientContactsTableSeeder::class);
        $this->call(ClientAgreementsTableSeeder::class);
        $this->call(ClientDebtsTableSeeder::class);
        $this->call(ClientUserTableSeeder::class);
        $this->call(GoodServiceCategoriesTableSeeder::class);
        //$this->call(GoodServiceSubCategoriesTableSeeder::class);
        // $this->call(GoodsTableSeeder::class);
        // $this->call(GoodNamesTableSeeder::class);
        // $this->call(GoodDetailsTableSeeder::class);
        // $this->call(GoodPricesTableSeeder::class);
        // $this->call(GoodWarehousesTableSeeder::class);
        $this->call(DocumentTypesTableSeeder::class);
        $this->call(PayOptionsTableSeeder::class);
        $this->call(MeasureOptionsTableSeeder::class);
        $this->call(ConditionOptionsTableSeeder::class);
    }
}
