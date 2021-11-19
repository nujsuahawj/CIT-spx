<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_transections', function (Blueprint $table) {
            $table->id();
            $table->string('rvcode');
            $table->integer('sender_unit');
            $table->integer('user_unit');
            $table->date('add_date');
            $table->integer('sendto_unit');
            $table->date('branch_id')->nullable();
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
        Schema::dropIfExists('logistic_transections');
    }
}
