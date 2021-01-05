<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatRoomMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_room_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('chat_room_id');
            $table->unsignedInteger('user_id');
            $table->longText('message');
            $table->timestamps();

            $table->foreign('chat_room_id')->references('id')->on('chat_rooms');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_room_messages');
    }
}
