<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowerballsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powerballs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('draw_date')->unique();
            $table->integer('b1');
            $table->integer('b2');
            $table->integer('b3');
            $table->integer('b4');
            $table->integer('b5');
            $table->integer('powerball');
            $table->string('powerplay')->nullable();
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
        Schema::dropIfExists('powerballs');
    }
}