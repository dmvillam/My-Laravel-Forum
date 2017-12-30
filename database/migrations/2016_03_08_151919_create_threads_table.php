<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('title')->unique();
            $table->boolean('locked')->default(false);
            $table->boolean('sticky')->default(false);

            $table->integer('category_id')->index();
            $table->integer('board_id')->index();
            $table->integer('user_id')->index();

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
        Schema::drop('threads');
    }
}
