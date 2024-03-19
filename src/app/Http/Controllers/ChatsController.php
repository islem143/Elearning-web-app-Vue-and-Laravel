<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Modules\Chat\ChatService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{


    protected $chatService;
    public function __construct(ChatService $chatService)
    {

        $this->chatService = $chatService;
    }
    public function fetchMessages(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $receiverId = $request->query('receiver_id');
            $messages = $this->chatService->fetchMessages($userId, $receiverId);

            return $messages;
        } catch (Exception $e) {
            
            return response()->json(["message" => $e->getMessage()], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $message = $request->input('message');
            $receiverId = $request->receiver_id;
            $this->chatService->sendMessage($message, $receiverId);
        } catch (Exception $e) {
            return response()->json(["message" => "an error occured"], 500);
        }
    }
}
