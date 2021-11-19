<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->biginteger('month');
            $table->biginteger('year');
            $table->biginteger('total_salary');
            $table->biginteger('total_bonus')->nullable;
            $table->string('note')->nullable();
            $table->integer('branch_id');
            $table->integer('user_id');
            $table->integer('approve_id');
            $table->integer('del')->default('1');
            $table->date('approve_date')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
