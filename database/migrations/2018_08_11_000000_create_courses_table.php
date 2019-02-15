<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCoursesTable.
 */
class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->integer('semester');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->text('notice')->nullable();
            $table->text('notice_html')->nullable();
            $table->integer('user_id');
            $table->integer('difficulty');
            $table->integer('restrict_level');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('course_enroll_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->integer('user_id');
            $table->boolean('type_is_admin');
        });
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
