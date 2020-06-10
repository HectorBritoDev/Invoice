<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('emission_date')->default(1);
            $table->boolean('type')->default(1);
            $table->boolean('number')->default(1);
            $table->boolean('client')->default(1);
            $table->boolean('expiration_date')->default(1);
            $table->boolean('debt')->default(1);
            $table->boolean('invoiced')->default(1);
            $table->boolean('status')->default(1);
            $table->boolean('seller')->default(0);
            $table->boolean('unique_code')->default(0);

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
        Schema::dropIfExists('sale_configurations');
    }
}
