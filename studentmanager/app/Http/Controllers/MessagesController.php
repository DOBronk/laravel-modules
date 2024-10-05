<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
use App\Events\MessageSent;

class MessagesController extends Controller
{
    public function list_messages(Request $request)
    {
        $messages = $request->user()->messages()->get();
        $unread = count($messages->where('read', 0));

        return view('messages.list', [
            'messages' => $messages,
            'unread' => $unread,
        ]);
    }
    public function show_message(Request $request, $id)
    {
        $message = Messages::where('id', $id)->get()->first();

        return view('messages.show', [
            'message' => $message,
        ]);
    }

    public function create(Request $request)
    {
        $message = Messages::find(1);

        MessageSent::dispatch($message);
    }
}
