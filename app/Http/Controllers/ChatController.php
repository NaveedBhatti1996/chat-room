<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(){
        return view('chat');
    }

    public function send(Request $request){
        $user=User::find(Auth::id());
        event(new ChatEvent($request->message,$user));
        return $request->all();

    }


    public function saveChat($request){
        session('chat')->put($request->message);
    }
    

}
