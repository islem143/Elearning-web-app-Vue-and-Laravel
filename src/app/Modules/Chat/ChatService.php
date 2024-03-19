<?php

namespace App\Modules\Chat;

use App\Events\MessageSent;
use App\Models\Category;
use App\Models\Media;
use App\Models\Message;
use App\Models\Module;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatService
{
    // protected $validator;
    // public function __construct(CategoryValidator $validator)
    // {
    //     $this->validator = $validator;
    // }
    public function fetchMessages(int $userId, int $receiverId)
    {
        User::findOrFail($receiverId);
        $messages = Message::where(["user_id" => $userId, "receiver_id" => $receiverId])
            ->orWhere(
                function ($query) use ($receiverId, $userId) {
                    $query->where(["user_id" => $receiverId, "receiver_id" => $userId]);
                }


            )->get();
        return $messages;
    }
    public function sendMessage(string $message, int $receiverId)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'message' => $message,
            'user_id' => $user->id,
            'receiver_id' => $receiverId
        ]);
 
        MessageSent::dispatch($user, $message);
        return ['status' => 'Message Sent!'];
    }
}
