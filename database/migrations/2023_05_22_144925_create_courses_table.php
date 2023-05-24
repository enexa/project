<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('thumbnail');
            $table->string('video');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
