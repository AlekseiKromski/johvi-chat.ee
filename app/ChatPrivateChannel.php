<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatPrivateChannel extends Model
{
    public $table = 'chat_private_channels';
    public $timestamps = true;
    public $guarded = [];
}
