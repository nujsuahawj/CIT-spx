<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('logo')->nullable();
            $table->string('company_photo')->nullable();
            $table->string('structure_photo')->nullable();
            $table->string('company_name_la')->nullable();
            $table->string('company_name_en')->nullable();
            $table->string('dividend_id')->nullable();//ລະຫັດເງິນປັນຜົນ
            $table->string('tax_id')->nullable();//ລະຫັດອາກອນລາຍໄດ້
            $table->string('address_la')->nullable();
            $table->string('address_en')->nullable();
            $table->integer('vill_id')->nullable();
            $table->integer('dis_id')->nullable();
            $table->integer('pro_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('director')->nullable();
            $table->string('sign1')->nullable();
            $table->string('sign2')->nullable();
            $table->string('sign3')->nullable();
            $table->string('sign4')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook_fanpage')->nullable();
            $table->string('youtube')->nullable();
            $table->string('google_map')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->text('bill_header')->nullable();
            $table->text('bill_footer')->nullable();
            $table->integer('active')->default('1');//0 inactive
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
        Schema::dropIfExists('branches');
    }
}
