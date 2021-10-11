<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplySchool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('apply_school')) {
            Schema::create('apply_school', function (Blueprint $table) {
                $table->increments('id');
                $table->integer("teacher_id")->comment("老师id");
                $table->string("school_name", 20)->nullable(false)->default("")->comment("名称");
                $table->string("school_province", 16)->nullable(false)->default("")->comment("省份");
                $table->string("school_city", 16)->nullable(false)->default("")->comment("城市");
                $table->string("school_area", 16)->nullable(false)->default("")->comment("地区");
                $table->string("school_address", 32)->nullable(false)->default("")->comment("详细地址");
                $table->tinyInteger("status")->nullable(false)->default(0)->comment("状态：0待审核,1通过,2拒绝");
                $table->string("reason", 100)->default("")->comment("拒绝原因");
                $table->index("teacher_id", "idx_teacher_id");
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
        Schema::dropIfExists('apply_school');
    }
}
