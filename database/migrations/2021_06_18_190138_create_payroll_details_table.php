<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_id');
            $table->integer('emp_id');
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->biginteger('amount')->nullable();
            $table->biginteger('bonus')->nullable();
            $table->string('note');
            $table->integer('del')->default('0');
            $table->integer('branch_id');
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
        Schema::dropIfExists('payroll_details');
    }
}
