<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_names', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('good_id');
            $table->foreign('good_id')->references('id')->on('goods')->onDelete('cascade');
            $table->string('other_name');
            $table->string('other_code');
            $table->string('other_reference');
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
        Schema::dropIfExists('good_names');
    }
}
