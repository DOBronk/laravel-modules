<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
use App\Models\User;
use App\Events\MessageSent;
use App\Http\Requests\StoreMessageRequest;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = $request->user()->messages()->get();
        $unread = count($messages->where('read', 0));
        $sent = $request->input('sent');

        return view('messages.list', [
            'messages' => $messages,
            'unread' => $unread,
            'sent' => (int) isset($sent),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $to_user = $request->input('to-user');

        if (!isset($to_user)) {
            abort(500, 'Missing user');
        }

        $user = User::find($to_user);

        if (!isset($user)) {
            abort(500, 'User not found');
        }

        return view('messages.create', [
            'to_user' => $user,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = new Messages();
        $vars = $request->post();

        $message->subject = $vars['subject'];
        $message->message = $vars['message'];
        $message->user_id = $vars['to_user_id'];
        $message->from_user_id = $request->user()->id;
        $message->read = 0;

        $message->save();

        MessageSent::dispatch($request->user()->unread_messages(), $request->user()->messages()->count(), $message);

        return redirect(route('messages.index', ['sent' => 1]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Messages::find($id);

        if (!$message) {
            abort(404, 'Message not found');
        }

        return view('messages.show', [
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = Messages::find($id);

        if (!$message) {
            abort(404, 'Message not found');
        }

        $deleted = $message->delete();

        return redirect(route('messages.index', ['deleted' => (int) $deleted]));
    }
}
