<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_transections', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->integer('month');
            $table->integer('year');
            $table->biginteger('amount');
            $table->biginteger('bonus')->nullable();
            $table->string('note');
            $table->integer('user_id');
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
        Schema::dropIfExists('payroll_transections');
    }
}
