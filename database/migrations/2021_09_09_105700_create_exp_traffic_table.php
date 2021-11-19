<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_traffic', function (Blueprint $table) {
            $table->id();
            $table->string('trf_code');
            $table->integer('exp_id');
            $table->string('currency_code');
            $table->integer('amount');
            $table->integer('user_create');
            $table->integer('branch_id');
            $table->date('date_create');
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
        Schema::dropIfExists('exp_traffic');
    }
}
