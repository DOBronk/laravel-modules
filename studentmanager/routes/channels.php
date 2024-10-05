<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Broadcast::channel('messages.{userId}', function (User $user, int $userId) {
    return $user->id === $userId;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});