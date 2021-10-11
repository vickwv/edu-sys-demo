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
                $table->integer("teacher_id")->comment("老师id");
                $table->string("email", 20)->nullable(false)->default("")->comment("邮箱");
                $table->tinyInteger("status")->nullable(false)->default(0)->comment("状态:0待接受,1邀请成功,2邀请过期");
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
        Schema::dropIfExists('teacher_invite');
    }
}
