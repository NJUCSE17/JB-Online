<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('student_id');
                $table->string('name');
                $table->string('email')->unique();
                $table->boolean('want_email')->default(true);
                $table->string('avatar_type')->default('gravatar');
                $table->string('avatar_upload')->nullable();
                $table->string('avatar_github')->nullable();
                $table->string('blog_feed_url')->nullable();
                $table->string('password');
                $table->timestamp('email_verified_at')->nullable();
                $table->timestamp('activated_at')->nullable();
                $table->smallInteger('privilege_level')->default(3);
                $table->string('timezone')->default('Asia/Shanghai');
                $table->timestamp('last_login_at')->nullable();
                $table->string('last_login_ip')->nullable();
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
