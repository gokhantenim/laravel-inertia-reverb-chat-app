<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Room;

Broadcast::channel('room.{id}', function ($user, $id) {
    return $user->only('id', 'name');
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    if($id == 'admin' && $user->type == 'admin') return true;
    return $user->id == $id;
});

Broadcast::channel('room.{id}', function ($user, $id) {
    return $user->canAccessRoom($id);
});

Broadcast::channel('roomonline.{id}', function ($user, $id) {
    if($user->canAccessRoom($id)){
        return ['id' => $user->id, 'name' => $user->name];
    }
});
