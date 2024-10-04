<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;

class MessagesController extends Controller
{
    public function list_messages(Request $request)
    {
        $messages = $request->user()->messages()->get();
        $unread = count($messages->where('read', 0));

        return view('messages.list', [
            'messages' => $messages,
            'unread' => $unread,
            'id' => $request->user()->id
        ]);
    }
    public function show_message(Request $request, $id)
    {
        $message = Messages::where('id', $id)->get()->first();

        return view('messages.show', [
            'message' => $message,
            'id' => $request->user()->id
        ]);
    }
}
