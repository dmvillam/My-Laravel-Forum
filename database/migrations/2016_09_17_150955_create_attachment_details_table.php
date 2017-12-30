<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attachment_id')->index();

            $table->string('desc', 2000);
            $table->boolean('featured')->default(false);
            $table->boolean('pinned')->default(false);
            $table->boolean('locked')->default(false);

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attachment_details');
    }
}
