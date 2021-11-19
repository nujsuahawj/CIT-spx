<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipOutTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_out_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('shipout_date');
            $table->integer('vihicle_id');
            $table->integer('emp_id');
            $table->integer('total_goods');
            $table->integer('shipping_id'); //ສະຖານະກຳລັງຂົນສົ່ງ ແລະ ປ່ຽນລາຍການສະຖານະໃນ Receive Transaction ນຳ
            $table->integer('creator_id');
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
        Schema::dropIfExists('ship_out_transactions');
    }
}
