<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('emp_id')->nullable();
            $table->string('role_id')->default('6');//1 admin; 2 staff; 3 unit; 4 customer
            $table->string('image')->default();
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
        Schema::dropIfExists('users');
    }
}
