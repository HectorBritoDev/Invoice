<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_warehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('good_id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
            $table->string('name');
            $table->string('adress');
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
        Schema::dropIfExists('good_warehouses');
    }
}
