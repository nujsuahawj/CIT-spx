<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticDetailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_detail_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('lgt_id');
            $table->integer('detail_id');
            $table->string('rvcode');
            $table->string('code');
            $table->integer('good_id');
            $table->integer('product_type_id');
            $table->integer('large');
            $table->integer('height');
            $table->integer('longs');
            $table->integer('weigh');
            $table->double('amount');
            $table->string('paid_type');
            $table->integer('sender_unit');
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->string('status');
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
        Schema::dropIfExists('logistic_detail_lists');
    }
}
