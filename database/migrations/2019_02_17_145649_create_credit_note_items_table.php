<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_note_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('credit_note_id');
            $table->foreign('credit_note_id')->references('id')->on('credit_notes')->onDelete('cascade');
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
        Schema::dropIfExists('credit_note_items');
    }
}
