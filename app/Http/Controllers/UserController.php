<?php

namespace App\Http\Controllers;

use App\ChatRoomMember;
use App\chatRoomMessages;
use App\ChatRooms;
use App\Events\NewMessage;
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

    public function getMessages($id)
    {
        $messages = chatRoomMessages::where('chat_room_id', '=', $id)->orderBy('id', 'desc')->limit(15)->get();
        $messages = $this->getUserWithMessages($messages);
        return response()->json($messages);
    }

    public function getChatInfo($id){
        return response()->json(ChatRooms::find($id));
    }

    public function getUserChats(){
        $chats = ChatRoomMember::where('user_id', '=', Auth::id())->orderBy('id', 'desc')->get();
        foreach ($chats as $chat){
            $chat->user = $chat->user;
            $chat->chatroom = $chat->chatroom;
        }
        return response()->json($chats);
    }

    public function joinUserIntoChat($id){
        if (count(ChatRoomMember::where('user_id', '=', Auth::id())->where('chat_room_id', '=', $id)->get()) != 0){
            return response()->json(['error' => 'вы уже находитесь в чате'], 405);
        }
        if(ChatRoomMember::find($id) == null){
            return response()->json(['error' => 'чата не существует'], 404);
        }
        if(!$chat = ChatRoomMember::create([
            'user_id' => Auth::id(),
            'chat_room_id' => $id
        ])){
            //Will return json for display error
            return abort(404);
        }
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
}
