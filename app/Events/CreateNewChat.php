<?php

namespace App\Events;

use App\ChatPrivateMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateNewChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public $id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chat, $id)
    {
        $this->chat = $chat;
        $this->id = $id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $this->chat->sender = $this->chat->user;
        $this->chat->recipient = $this->chat->recipient;

        $message = ChatPrivateMessage::where('channel_id', '=', $this->chat->channel_id)
            ->orderBy('id', 'desc')
            ->limit(1)->get();
        if(count($message) == 0){
            $this->chat->message_created_at = date('Y-m-d H:i:s');
            $this->chat->message = 'No messages';
        }else{
            $this->chat->message_created_at = $message[0]->created_at->format('Y-m-d H:i:s');
            $this->chat->message = $message[0]->message;
        }
        return 'user-channel.' . $this->id;
    }
}
