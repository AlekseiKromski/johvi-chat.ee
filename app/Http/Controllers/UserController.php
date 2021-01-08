<?php

namespace App\Http\Controllers;

use App\ChatRoomHistory;
use App\ChatRoomMember;
use App\chatRoomMessages;
use App\ChatRooms;
use App\Events\JoinUser;
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
        $chatRoom = ChatRooms::find($id);
        $chatRoom->users_count = count(ChatRoomMember::where('chat_room_id', '=',$chatRoom->id)->get());
        return response()->json($chatRoom);
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

    public function joinedToChannel($id){
        $history = ChatRoomHistory::where('chat_room_id', '=', $id)
            ->where('user_id', '=', Auth::id())
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
        if(isset($history->status) and $history->status != 'connect'){
            ChatRoomHistory::create([
                'user_id' => Auth::id(),
                'chat_room_id' => $id,
                'status' => 'connect'
            ]);
            event(new JoinUser(['user_id' => Auth::id(), 'room_id' => $id, 'status' => 'connect']));
        }
        if(count($history) == 0){
            ChatRoomHistory::create([
                'user_id' => Auth::id(),
                'chat_room_id' => $id,
                'status' => 'connect'
            ]);
            event(new JoinUser(['user_id' => Auth::id(), 'room_id' => $id, 'status' => 'connect']));
        }

    }

    public function disconnectUserChannel($id){
        $history = ChatRoomHistory::where('chat_room_id', '=', $id)
            ->where('user_id', '=', Auth::id())
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
        dd($history);
        if(isset($history->status) and $history->status != 'disconnect'){

            ChatRoomHistory::create([
                'user_id' => Auth::id(),
                'chat_room_id' => $id,
                'status' => 'disconnect'
            ]);
            event(new JoinUser(['user_id' => Auth::id(), 'room_id' => $id, 'status' => 'connect']));
        }
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
