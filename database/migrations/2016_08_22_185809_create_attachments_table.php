<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('gallery_id');

            $table->string('file_name');
            $table->string('original_name');
            $table->string('hash')->unique();
            $table->string('ext', 4);
            $table->integer('size');
            $table->mediumInteger('downloads');
            $table->mediumInteger('width');
            $table->mediumInteger('height');
            $table->string('mime_type', 20);
            $table->boolean('approved')->default(false);;

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
        Schema::drop('attachments');
    }
}
