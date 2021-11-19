<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaydevidendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paydevidends', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->integer('amount');
            $table->integer('devidend');
            $table->integer('vat');
            $table->integer('money');
            $table->integer('branch_id');
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
        Schema::dropIfExists('paydevidends');
    }
}
