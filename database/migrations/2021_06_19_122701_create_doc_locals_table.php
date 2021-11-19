<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocLocalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_locals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('type_id');
            $table->string('title');
            $table->integer('storage_id');
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->string('file');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('doc_locals');
    }
}
