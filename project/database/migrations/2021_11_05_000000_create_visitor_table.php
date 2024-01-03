<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('date');
            $table->ipAddress('ip');
            $table->bigInteger('timein');
            $table->tinyInteger('online');
            $table->string('platformname');
            $table->string('platformfamily');
            $table->string('browserfamily');
            $table->tinyInteger('ismobile');
            $table->tinyInteger('istablet');
            $table->tinyInteger('isdesktop');
            $table->tinyInteger('isbot');
            $table->tinyInteger('ischrome');
            $table->tinyInteger('isfirefox');
            $table->tinyInteger('isopera');
            $table->tinyInteger('issafari');
            $table->tinyInteger('isie');
            $table->tinyInteger('isedge');
            $table->string('devicefamily');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor');
    }
}
