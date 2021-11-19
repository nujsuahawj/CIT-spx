<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_goods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('goods_types_id')->nullable();
            $table->integer('product_type_id')->nullable();
            $table->integer('vihicle_type_id')->nullable();
            $table->integer('prodcut_count')->nullable();
            $table->integer('large')->nullable();
            $table->integer('height')->nullable();
            $table->integer('longs')->nullable();
            $table->integer('weight')->nullable();
            $table->string('detal')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default('1');
            $table->integer('user_id');
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
        Schema::dropIfExists('call_goods');
    }
}
