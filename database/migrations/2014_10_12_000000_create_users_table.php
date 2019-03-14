<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('want_email')->default(true);
            $table->string('avatar_type')->default('gravatar');
            $table->string('avatar_upload')->nullable();
            $table->string('avatar_github')->nullable();
            $table->string('blog')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
