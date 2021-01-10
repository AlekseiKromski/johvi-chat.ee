<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\ChatPrivate;
use App\User;
class ChatPrivateMessage extends Model
{
    use SoftDeletes;

    public $table = 'chat_private_messages';
    public $timestamps = true;
    public $guarded = [];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function chat_private(){
        return $this->hasOne('App\ChatPrivate', 'id', 'chat_private_id');
    }

    public function user_recipient(){
        return $this->hasOne('App\User', 'id', 'user_2');
    }
}
