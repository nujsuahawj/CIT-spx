<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('title_la');
            $table->string('title_en')->nullable();
            $table->string('slug');
            $table->longtext('short_des_la')->nullable();
            $table->longtext('short_des_en')->nullable();
            $table->longtext('des_la')->nullable();
            $table->longtext('des_en')->nullable();
            $table->integer('status')->default('1');
            $table->integer('user_id');
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
        Schema::dropIfExists('pages');
    }
}
