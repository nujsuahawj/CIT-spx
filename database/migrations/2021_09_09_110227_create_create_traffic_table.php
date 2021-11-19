<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_traffic', function (Blueprint $table) {
            $table->id();
            $table->string('trf_code');
            $table->integer('vh_id');
            $table->text('emp_id')->nullable();
            $table->integer('user_create');
            $table->integer('branch_id');
            $table->datetime('start_date');
            $table->datetime('stop_date');
            $table->string('staus');
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
        Schema::dropIfExists('create_traffic');
    }
}
