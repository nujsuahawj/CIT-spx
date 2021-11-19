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
            $table->id();
            $table->string('image')->nullable();
            $table->string('title_la');
            $table->string('title_en');
            $table->string('slug');
            $table->text('shor_des_la')->nullable();
            $table->text('shor_des_en')->nullable();
            $table->longtext('des_la')->nullable();
            $table->longtext('des_en')->nullable();
            $table->integer('postcate_id')->nullable();
            $table->integer('tag_id')->nullable();
            $table->integer('is_new')->default('1');
            $table->integer('view')->nullable();
            $table->integer('published')->default('1');
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('del')->default('1');
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
        Schema::dropIfExists('posts');
    }
}
