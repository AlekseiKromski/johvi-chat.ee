<?php

namespace App\Http\Controllers;

use App\ChatPrivate;
use App\ChatPrivateMessage;
use App\ChatRoomHistory;
use App\ChatRoomMember;
use App\chatRoomMessages;
use App\ChatRooms;
use App\Events\JoinUser;
use App\Events\NewMessage;
use App\Events\PrivateNewMessage;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function index(){
        return view('looechat');
    }

    public function sendMessage(Request $request){
        if(!$message = chatRoomMessages::create([
            'chat_room_id' => $request->room_id,
            'user_id' => Auth::user()->id,
            'message' => $request->message
        ])){
            //Will return json for display error
            return abort(404);
        }
        $message->user = $message->user;
        event(new NewMessage($message));
    }

    public function sendPrivateMessage(Request $request){
        if(!$message = ChatPrivateMessage::create([
            'channel_id' => $request->channel_id,
            'user_id' => Auth::user()->id,
            'user_2' => $request->user_recipient,
            'message' => $request->message,
        ])){
            //Will return json for display error
            return abort(404);
        }
        $message->user = $message->user;
        $message->user_recipient = $message->user_recipient;
        event(new PrivateNewMessage($message, $message->channel_id));
    }

    public function getMessages($id)
    {
        $messages = chatRoomMessages::where('chat_room_id', '=', $id)->orderBy('id', 'desc')->limit(15)->get();
        $messages = $this->getUserWithMessages($messages);
        return response()->json($messages);
    }

    public function getChatInfo($id){
        $chatRoom = ChatRooms::find($id);
        $chatRoom->users_count = count(ChatRoomMember::where('chat_room_id', '=',$chatRoom->id)->get());
        return response()->json($chatRoom);
    }

    public function getUserChatRooms(){
        $chats = ChatRoomMember::where('user_id', '=', Auth::id())->orderBy('id', 'desc')->get();
        foreach ($chats as $chat){
            $chat->user = $chat->user;
            $chat->chatroom = $chat->chatroom;
        }
        return response()->json($chats);
    }

    public function getUserChatPrivates(){
        $chats = ChatPrivate::where('user_id', '=', Auth::id())
            ->orderBy('id', 'desc')->get();
        foreach ($chats as $chat){
            $chat->sender = $chat->user;
            $chat->recipient = $chat->recipient;
        }
        return response()->json($chats);
    }

    public function getPrivateMessages($channel){
        $chats = ChatPrivate::where('channel_id', '=', $channel)->get();
        $forbidden = true;
        foreach ($chats as $chat){

            if($chat->user->id == Auth::id() || $chat->recipient->id == Auth::id()){
                $forbidden = false;
            }
        }
        if(!$forbidden){
            $messages = ChatPrivateMessage::where('channel_id','=',$channel)->get();
            $message = $this->getUserWithMessagesWithRecipient($messages);
            return response()->json($messages);
        }else{
            return abort(403);
        }
    }

    public function joinUserIntoChat($id){
        if (count(ChatRoomMember::where('user_id', '=', Auth::id())->where('chat_room_id', '=', $id)->get()) != 0){
            return response()->json(['error' => 'вы уже находитесь в чате'], 405);
        }
        if(ChatRooms::find($id) == null){
            return response()->json(['error' => 'чата не существует'], 404);
        }
        if(!$chat = ChatRoomMember::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $id
        ])){
            //Will return json for display error
            return abort(404);
        }
        $chat->user = $chat->user;
        $chat->chatroom = $chat->chatroom;
        return response()->json($chat);
    }

    //Sys functions
    private function getUserWithMessages($messages){
        $messages_reverse = [];
        foreach ($messages as $message) {
            $message->user = $message->user;
            array_unshift($messages_reverse, $message);
        }
        return $messages_reverse;
    }

    //Sys functions
    private function getUserWithMessagesWithRecipient($messages){
        foreach ($messages as $message) {
            $message->user = $message->user;
            $message->user_recipient = $message->user_recipient;
        }
        return $messages;
    }
}
