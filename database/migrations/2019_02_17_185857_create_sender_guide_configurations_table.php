<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenderGuideConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sender_guide_configurations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->boolean('phone')->default(1);
            $table->boolean('email')->default(1);
            $table->boolean('web')->default(1);
            $table->boolean('user_description')->default(1);
            $table->boolean('seller')->default(0);
            $table->boolean('reference')->default(0);
            $table->boolean('price')->default(0);
            $table->boolean('client_message')->default(1);
            $table->boolean('internal_message')->default(1);
            $table->boolean('detraction_account')->default(1);
            $table->boolean('bank_account')->default(1);

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
        Schema::dropIfExists('sender_guide_configurations');
    }
}
