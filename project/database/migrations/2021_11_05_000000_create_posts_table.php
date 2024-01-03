<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('post_author');
            $table->string('post_title');
            $table->string('post_name');
            $table->text('post_excerpts')->nullable();
            $table->longText('post_content')->nullable();
            $table->string('post_type', '64');
            $table->bigInteger('term_id');
            $table->bigInteger('post_views');
            $table->text('post_tags')->nullable();
            $table->tinyInteger('post_pin');
            $table->bigInteger('post_orders');
            $table->dateTime('post_modified')->useCurrent();
            $table->dateTime('post_date')->useCurrent();
            $table->tinyInteger('comment_status');
            $table->tinyInteger('post_status');
            $table->bigInteger('translate')->nullable();
            $table->string('language');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
