<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //DATOS CLIENTE
            $table->bigInteger('ruc')->nullable();
            $table->bigInteger('dni')->nullable();
            $table->bigInteger('passport')->nullable();
            $table->string('client_name');
            $table->string('client_lastname')->nullable();
            $table->string('sunat_situation')->nullable();

            $table->string('client_email')->nullable();
            $table->longText('client_main_adress')->nullable();
            $table->bigInteger('client_cellphone')->nullable();
            $table->string('client_note')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clients');
    }
}
