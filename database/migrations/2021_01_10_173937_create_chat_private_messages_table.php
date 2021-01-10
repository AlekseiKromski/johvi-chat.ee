<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatPrivateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_private_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('chat_private_id');
            $table->unsignedInteger('user_id');
            $table->longText('message');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('chat_private_id')->references('id')->on('chat_privates');
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
        Schema::dropIfExists('chat_private_messages');
    }
}
