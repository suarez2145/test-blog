<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger('author_id')->unsigned();
            $table->timestamps();
            $table->text('title'); // Title of our blog post  
            $table->text('body'); // Body of our blog post
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            // $table->BigInteger('user_id')->unsigned()->nullable(); // user_id of our blog post author
        });
        // this below defines our new 'blog_comments' tables in the database and the relationship to the 'blog_post' table;

        Schema::create('blog_comments', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('comment_post_id');
            $table->bigInteger('author_id')->unsigned();
            $table->string('comment_txt');
            $table->timestamps();
            $table->foreign('comment_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
};
