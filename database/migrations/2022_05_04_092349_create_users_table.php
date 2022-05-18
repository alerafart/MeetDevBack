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
            $table->id();
            $table->string('lastname');
            $table->string('firtname');
            $table->string('city');
            $table->tinyint('department');
            $table->integer('zip_code');
            $table->string('email_address');
            $table->integer('phone');
            $table->string('password');
            $table->integer('dev_id');
            $table->integer('recrut_id');
            $table->tinyint('subscribe_to_push_notif');
            $table->string('profile_picture');
            $table->string('rememberToken');
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
