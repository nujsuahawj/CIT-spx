<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_details', function (Blueprint $table) {
            $table->id();
            $table->integer('lgt_id');
            $table->string('rvcode');
            $table->integer('sender_unit');
            $table->integer('user_unit');
            $table->date('add_date');
            $table->integer('sendto_unit');
            $table->integer('user_receive')->nullable();
            $table->date('receive_date')->nullable();
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
        Schema::dropIfExists('logistic_details');
    }
}
