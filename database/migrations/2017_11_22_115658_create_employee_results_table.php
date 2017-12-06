<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_results', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('year');
            $table->integer('month');
            $table->integer('day');
            $table->integer('seconds');
            $table->string('location');
            $table->integer('sid');
            $table->string('name');
            $table->string('clockout')->default('yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_results');
    }
}
