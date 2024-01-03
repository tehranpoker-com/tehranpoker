<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersmetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersmeta', function (Blueprint $table) {
            $table->bigIncrements('meta_id');
            $table->bigInteger('user_id');
            $table->text('meta_key');
            $table->longText('meta_value')->nullable();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usersmeta');
    }
}
