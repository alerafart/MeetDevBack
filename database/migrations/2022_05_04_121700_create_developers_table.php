<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevelopersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('available_for_recruiters');
            $table->integer('available_for_developers');
            $table->integer('minimum_salary_requested');
            $table->integer('maximum_salary_requested');
            $table->integer('age');
            $table->integer('years_of_experience');
            $table->string('github_link');
            $table->string('portfolio_link');
            $table->string('other_link');
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
        Schema::dropIfExists('developers');
    }
}
