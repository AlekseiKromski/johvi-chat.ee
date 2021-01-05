<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRooms extends Model
{
    public $table = 'chat_rooms';
    public $timestamps = true;
    public $guarded = [];
}
