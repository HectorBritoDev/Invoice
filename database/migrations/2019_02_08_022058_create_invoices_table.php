<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('ruc')->nullable();
            $table->string('dni')->nullable();
            $table->string('code')->nullable();
            $table->string('serie')->nullable();

            $table->string('sunat_resolution')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_main_adress')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->string('emission_date')->nullable();
            $table->string('condition')->nullable();
            $table->string('expiration_date')->nullable();
            $table->string('coin')->nullable();

            $table->integer('discount')->nullable();
            $table->integer('total')->nullable();
            $table->integer('sub_total')->nullable();
            $table->integer('tax')->nullable();

            $table->string('status')->nullable();
            $table->longText('note')->nullable();
            $table->longText('internal_message')->nullable();
            $table->string('detraction_account')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('file')->nullable();
            $table->string('pdf')->nullable();

            $table->integer('budget_id')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
