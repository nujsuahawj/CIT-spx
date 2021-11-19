<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocExportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_exports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('date');
            $table->integer('type_id');
            $table->string('title');
            $table->integer('external_id');
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
        Schema::dropIfExists('doc_exports');
    }
}
