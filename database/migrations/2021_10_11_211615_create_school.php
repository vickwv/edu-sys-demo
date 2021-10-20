<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('school')) {
            Schema::create('school', function (Blueprint $table) {
                $table->increments('id');
                $table->string("name", 20)->nullable(false)->default("")->comment("名称");
                $table->string("province", 16)->nullable(false)->default("")->comment("省份");
                $table->string("city", 16)->nullable(false)->default("")->comment("城市");
                $table->string("area", 16)->nullable(false)->default("")->comment("地区");
                $table->string("address", 32)->nullable(false)->default("")->comment("详细地址");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school');
    }
}
