<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatPrivate extends Model
{
    public $table = 'chat_privates';
    public $timestamps = true;
    public $guarded = [];

    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function recipient(){
        return $this->hasOne('App\User', 'id', 'user_2');
    }
}
