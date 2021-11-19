<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->date('bod')->nullable();
            $table->integer('position_id');
            $table->string('card_id')->nullable();
            $table->date('card_enddate')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->integer('vill_id');
            $table->integer('dis_id');
            $table->integer('pro_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('file')->nullable();
            $table->integer('status')->default('1');//0 ແມ່ນອອກແລ້ວ
            $table->string('note')->nullable();
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('del')->default('1');
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
        Schema::dropIfExists('employees');
    }
}
