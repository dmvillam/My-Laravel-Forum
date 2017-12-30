<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_replies', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('blog_id')->index();
            $table->integer('entry_id')->index();
            $table->integer('reply_id')->index();
            $table->string('content', 2000);

            $table->softDeletes();

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
        Schema::drop('entry_replies');
    }
}
