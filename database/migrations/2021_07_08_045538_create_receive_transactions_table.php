<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiveTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('branch_send');//
            $table->integer('customer_send');//User role = customer
            $table->integer('branch_receive');
            $table->integer('customer_receive');//User role = customer
            $table->integer('goods_type_id');
            $table->string('goods_name')->nullable();
            $table->integer('coculator_type_id');
            $table->string('unit');
            $table->bigInteger('amount');
            $table->string('image')->nullable();
            $table->integer('payment_type_id');
            $table->integer('payment_id');
            $table->integer('shipping_id');
            $table->integer('creator_id');
            $table->integer('branch_create_id');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('receive_transactions');
    }
}
