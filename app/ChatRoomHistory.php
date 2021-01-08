<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ChatRooms;
class ChatRoomHistory extends Model
{
    public $table = 'chat_room_history';
    public $timestamps = true;
    public $guarded = [];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function chatroom(){
        return $this->hasOne('App\ChatRooms', 'id', 'chat_room_id');
    }
}
