<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalculatorPriceKgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calculator_price_kgs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('price_local');
            $table->bigInteger('price_south');
            $table->bigInteger('price_north');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('calculator_price_kgs');
    }
}
