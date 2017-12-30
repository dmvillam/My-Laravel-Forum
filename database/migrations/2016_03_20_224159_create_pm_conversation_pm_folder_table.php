<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmConversationPmFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_conversation_pm_folder', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('pm_conversation_id')->index();
            $table->integer('pm_folder_id')->index();

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
        Schema::drop('pm_conversation_pm_folder');
    }
}
