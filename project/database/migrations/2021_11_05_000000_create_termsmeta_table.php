<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsmetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termsmeta', function (Blueprint $table) {
            $table->bigIncrements('meta_id');
            $table->bigInteger('term_id');
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
        Schema::dropIfExists('termsmeta');
    }
}
