<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAssignmentsTable.
 */
class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('course_id');
            $table->string('name');
            $table->text('content');
            $table->dateTime('due_time');
            $table->integer('issuer')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('assignment_finish_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('assignment_id');
            $table->dateTime('finished_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('assignments_finish_records');
    }
}
