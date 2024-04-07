<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuari)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
       
    }

    public function getMessages(User $loggedUser, User $otherUser) {
        $messages = Message::where(function ($query) use ($loggedUser, $otherUser) {
            $query->where('id_user', $loggedUser->id_user)
                  ->where('id_user_receiver', $otherUser->id_user);
        })->orWhere(function ($query) use ($loggedUser, $otherUser) {
            $query->where('id_user', $otherUser->id_user)
                  ->where('id_user_receiver', $loggedUser->id_user);
        })->get();
    
        // Marcar cada mensaje como propio o del otro usuario
        $messages->each(function ($message) use ($loggedUser) {
            $message->isMyMessage = $message->id_user === $loggedUser->id_user;
        });
    
        return response()->json($messages);
    }

    public function sendMessage(Request $request) {
        $message = new Message();
        $message->id_user = $request->input('id_user');
        $message->id_user_receiver = $request->input('id_user_receiver');
        $message->message = $request->input('message');
        $message->timestamp = date('Y-m-d H:i:s');
        $message->active = 1;
        $message->save();

        return response()->json($message);
    }

    public function deleteMessage(Request $request) {
        $message = Message::find($request->input('id_message'));
        $message->message = 'Mensaje eliminado';
        $message->active = false;
        $message->save();

        return response()->json($message);
    }
}

