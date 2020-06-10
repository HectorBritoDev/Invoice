<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_adress')->nullable();
            $table->integer('main')->default(0);

            //RELACIONES
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedInteger('department_id')->nullable();
            // $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedInteger('province_id')->nullable();
            // $table->foreign('province_id')->references('id')->on('provinces');

            $table->unsignedInteger('district_id')->nullable();
            //  $table->foreign('district_id')->references('id')->on('districts');

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

        Schema::dropIfExists('client_adresses');
    }
}
