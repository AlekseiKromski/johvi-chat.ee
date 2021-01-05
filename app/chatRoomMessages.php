<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class chatRoomMessages extends Model
{
    use SoftDeletes;

    public $table = 'chat_room_messages';
    public $timestamps = true;
    public $guarded = [];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
