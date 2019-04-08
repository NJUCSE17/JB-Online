<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesAndEnrollRecordsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'courses',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->integer('semester');
                $table->dateTime('start_time');
                $table->dateTime('end_time');
                $table->text('notice')->nullable();
                $table->text('notice_html')->nullable();
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'course_enroll_records',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('course_id');
                $table->foreign('course_id')->references('id')
                    ->on('courses')->onDelete('cascade');
                $table->boolean('type_is_admin')->default(false);
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_enroll_records');
    }
}
