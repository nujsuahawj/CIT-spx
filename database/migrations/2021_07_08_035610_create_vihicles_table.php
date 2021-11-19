<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVihiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vihicles', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('vihicle_type_id');
            $table->string('plate_number')->nullable();
            $table->string('series_number')->nullable();
            $table->string('power_number')->nullable();
            $table->date('road_fee_date')->nullable();
            $table->date('technic_date')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('note')->nullable();
            $table->integer('active')->default('1');
            $table->string('plate_pic')->nullable();
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
        Schema::dropIfExists('vihicles');
    }
}
