<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatRoomMember extends Model
{
    use SoftDeletes;

    public $table = 'chat_room_members';
    public $timestamps = true;
    public $guarded = [];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function chatroom(){
        return $this->hasOne('App\ChatRooms', 'id', 'chat_room_id');
    }
}
