<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacher extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('teacher')) {
            Schema::create('teacher', function (Blueprint $table) {
                $table->increments('id');
                $table->string("email", 20)->nullable(false)->default("")->comment("邮箱");
                $table->string("name", 20)->nullable(false)->default("")->comment("名称");
                $table->string("password", 100)->nullable(false)->default("")->comment("密码");
                $table->tinyInteger("role")->default(3)->comment("角色: 1 超级管理员 2 学校管理员 3教师");
                $table->tinyInteger("sex")->default(0)->comment("性别:1男0女");
                $table->tinyInteger("age")->default(0)->comment("年龄");
                $table->tinyInteger("status")->comment("状态: 1正常,0禁用");
                $table->unique("email", "idx_email");
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
        Schema::dropIfExists('teacher');
    }
}
