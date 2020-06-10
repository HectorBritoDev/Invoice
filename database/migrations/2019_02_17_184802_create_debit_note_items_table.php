<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebitNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debit_note_items', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('debit_note_id');
            $table->foreign('debit_note_id')->references('id')->on('debit_notes')->onDelete('cascade');
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
        Schema::dropIfExists('debit_note_items');
    }
}
