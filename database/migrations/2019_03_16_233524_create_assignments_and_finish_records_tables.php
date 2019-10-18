<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsAndFinishRecordsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'assignments',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('course_id');
                $table->foreign('course_id')->references('id')->on('courses');
                $table->string('name');
                $table->longText('content');
                $table->longText('content_html');
                $table->dateTime('due_time');
                $table->timestamps();
                $table->softDeletes();
            }
        );
        Schema::create(
            'assignment_finish_records',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')
                    ->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('assignment_id');
                $table->foreign('assignment_id')->references('id')
                    ->on('assignments')->onDelete('cascade');
                $table->timestamps();
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
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('assignment_finish_records');
    }
}
