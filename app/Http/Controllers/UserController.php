<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Http\Request;
use Auth;
class UserController extends Controller
{
    public function index(){
        return view('looechat');
    }

    public function sendMessage(Request $request){
        event(new NewMessage($request->message, Auth::user()->login));
    }
}
