<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{



    public function fetchMessages(Request $request)
    {
        $userId = Auth::user()->id;
        $querys = $request->query('receiver_id');
        return Message::where(["user_id" => $userId, "receiver_id" => $request->query('receiver_id')])
            ->orWhere(
                function ($query) use ($querys, $userId) {
                    $query->where(["user_id" => $querys, "receiver_id" => $userId]);
                }


            )->get();
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
