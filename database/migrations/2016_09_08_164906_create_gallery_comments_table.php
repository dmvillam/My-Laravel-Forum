<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_comments', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('gallery_id')->index();
            $table->integer('attachment_id')->index();
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
        Schema::drop('gallery_comments');
    }
}
