<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            //DATOS LOGIN
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->default(bcrypt('123'));
            $table->string('type')->default('user');
            $table->string('photo')->nullable()->default('profile.png');
            $table->string('social_reason')->nullable();
            $table->bigInteger('ruc')->nullable();
            $table->string('adress')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('public_email')->nullable();
            $table->string('web')->nullable();
            $table->string('description')->nullable();

            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
