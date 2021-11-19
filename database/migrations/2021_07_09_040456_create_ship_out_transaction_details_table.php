<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipOutTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_out_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ship_out_id');
            $table->integer('receive_tran_id');
            $table->string('goods_name');
            $table->string('unit');
            $table->bigInteger('amount');
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
        Schema::dropIfExists('ship_out_transaction_details');
    }
}
