<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherInvite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('teacher_invite')) {
            Schema::create('teacher_invite', function (Blueprint $table) {
                $table->increments('id');
                $table->integer("teacher_id")->comment("老师id")->index();
                $table->string("email", 32)->nullable(false)->default("")->comment("邮箱");
                $table->tinyInteger("status")->nullable(false)->default(0)->comment("状态:0待接受,1邀请成功,2邀请过期");
                $table->tinyInteger("is_sent")->nullable(false)->default(0)->comment("是否发送邮件: 1已发送 0未发送");
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
        Schema::dropIfExists('teacher_invite');
    }
}
