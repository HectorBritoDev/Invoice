<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->increments('id');
            //RELACIONES
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            //DATOS CONTACTO EMPRESA
            $table->string('client_contact_name');
            $table->string('client_contact_lastname')->nullable();
            $table->string('client_contact_email')->nullable();
            $table->bigInteger('client_contact_cellphone')->nullable();
            $table->bigInteger('client_contact_phone')->nullable();
            $table->integer('client_contact_anexo')->nullable();
            $table->string('client_contact_charge')->nullable();
            $table->date('client_contact_birthday')->nullable();
            $table->string('client_contact_responsableFor')->nullable();

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

        Schema::dropIfExists('client_contacts');
    }
}
