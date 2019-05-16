<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProblemsTable.
 */
class CreateBlogFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->text('permalink');
            $table->text('title');
            $table->longText('content');
            $table->text('author');
            $table->text('avatar');
            $table->dateTime('date');
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
        Schema::dropIfExists('blog_feeds');
    }
}
