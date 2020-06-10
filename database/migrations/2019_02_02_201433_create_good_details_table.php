<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('good_id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
            //$table->string('measure');
            // $table->string('brand')->nullable();
            // $table->string('model')->nullable();
            // $table->string('serie')->nullable();
            // $table->string('badge')->nullable();
            // $table->string('color')->nullable();
            // $table->string('size')->nullable();

            $table->string('name');
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
        Schema::dropIfExists('good_details');
    }
}
