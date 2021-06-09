<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTxlottosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txlottos', function (Blueprint $table) {
            $table->id();
            $table->date('draw_date');
            $table->integer('b1');
            $table->integer('b2');
            $table->integer('b3');
            $table->integer('b4');
            $table->integer('b5');
            $table->integer('b6');
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
        Schema::dropIfExists('txlottos');
    }
}
