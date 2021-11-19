<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpendTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expend_types', function (Blueprint $table) {
            $table->id();
            $table->string('exp_code');
            $table->string('expend_name');
            $table->string('currency_code');
            $table->integer('amount');
            $table->integer('user_create');
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
        Schema::dropIfExists('expend_types');
    }
}
