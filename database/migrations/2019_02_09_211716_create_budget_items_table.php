<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('budget_id');
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');;
            $table->integer('good_id');
            $table->string('name');
            $table->string('measure')->nullable();
            $table->string('reference');
            $table->string('quantity');
            $table->float('price');
            $table->integer('discount')->nullable();
            $table->float('total');
            $table->float('sub_total');
            $table->float('tax');
            $table->integer('igv_type');
            $table->integer('detraction')->nullable();
            $table->integer('retention')->nullable();

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
        Schema::dropIfExists('budget_items');
    }
}
