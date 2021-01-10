<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatPrivateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_private_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('chat_private_one');
            $table->unsignedInteger('chat_private_two');
            $table->timestamps();

            $table->foreign('chat_private_one')->references('id')->on('chat_privates');
            $table->foreign('chat_private_two')->references('id')->on('chat_privates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_private_channels');
    }
}
