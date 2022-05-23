<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Provider\fr_FR\Person;
use Faker\Provider\fr_FR\Address;
use Faker\Provider\fr_FR\PhoneNumber;
$faker = new Faker\Generator();
$faker->addProvider(new Faker\Provider\fr_FR\Address($faker));
$faker->addProvider(new Faker\Provider\fr_FR\PhoneNumber($faker));

class AddRowIntoUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firtname');
            $table->string('city');
            $table->integer('department');
            $table->integer('zip_code');
            $table->string('email_address');
            $table->integer('phone');
            $table->string('password');
            $table->foreignId('dev_id')->references('id')->on('developers');
            $table->foreignId('recrut_id')->references('id')->on('recruiters');
            $table->integer('recrut_id');
            $table->integer('subscribe_to_push_notif')->randomElement([1, 2]);
            $table->url('profile_picture');
            $table->timestamps('email_verified_at');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('users');
        });
    }
}
