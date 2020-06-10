<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('good_id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
            $table->string('wholesale_price');
            $table->string('unit_price');
            $table->integer('tax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('good_prices');
    }
}
