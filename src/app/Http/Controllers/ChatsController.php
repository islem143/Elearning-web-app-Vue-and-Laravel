<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{



    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $request->input('message'),
            'user_id' => $user->id,
            'receiver_id' => $request->receiver_id
        ]);
        //broadcast(new MessageSent($user, $message));
        MessageSent::dispatch($user, $message);

        return ['status' => 'Message Sent!'];
    }
}
