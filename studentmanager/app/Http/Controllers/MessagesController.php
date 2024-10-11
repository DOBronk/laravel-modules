<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages;
use App\Events\MessageSent;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $messages = $request->user()->messages()->get();
        $unread = count($messages->where('read', 0));

        return view('messages.list', [
            'messages' => $messages,
            'unread' => $unread,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $message = Messages::find(1);

        MessageSent::dispatch($message);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = Messages::find(1);

        MessageSent::dispatch($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Messages::where('id', $id)->get()->first();

        return view('messages.show', [
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
