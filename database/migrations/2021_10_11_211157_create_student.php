<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('student')) {
            Schema::create('student', function (Blueprint $table) {
                $table->increments('id');
                $table->integer("school_id", false)->nullable(false)->comment("学校id");
                $table->string("email", 32)->nullable(false)->unique()->default("")->comment("邮箱");
                $table->string("name", 20)->nullable(false)->default("")->comment("名称");
                $table->string("line_id", 64)->nullable(false)->default("")->comment("line_id");
                $table->string("password", 100)->nullable(false)->default("")->comment("密码");
                $table->tinyInteger("sex")->default(0)->comment("性别:0未知1男2女");
                $table->tinyInteger("age")->default(0)->comment("年龄");
                $table->tinyInteger("status")->comment("状态: 1正常,0禁用");
                $table->index("school_id", "idx_school_id");
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
        Schema::dropIfExists('student');
    }
}
