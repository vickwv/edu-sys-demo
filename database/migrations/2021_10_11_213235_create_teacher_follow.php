<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherFollow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('teacher_follow')) {
            Schema::create('teacher_follow', function (Blueprint $table) {
                $table->increments('id');
                $table->integer("teacher_id")->nullable(false)->comment("老师id");
                $table->integer("student_id")->nullable(false)->comment("学生id");
                $table->index("teacher_id", "idx_teacher_id");
                $table->index("student_id", "idx_student_id");
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
        Schema::dropIfExists('teacher_follow');
    }
}
