<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_traffic', function (Blueprint $table) {
            $table->id();
            $table->string('trf_code');
            $table->string('rvcode');
            $table->integer('sender_unit')->nullable();
            $table->integer('user_unit')->nullable();
            $table->date('add_date')->nullable();
            $table->date('sendto_unit')->nullable();
            $table->date('receive_date')->nullable();
            $table->integer('user_receive')->nullable();
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
        Schema::dropIfExists('list_traffic');
    }
}
