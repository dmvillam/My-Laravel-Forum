<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_comments', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('content', 10000);
            $table->integer('reply_level');

            $table->integer('user_id')->index();
            $table->integer('user_profile_id')->index();
            $table->integer('profile_comment_id')->index();

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
        Schema::drop('profile_comments');
    }
}
