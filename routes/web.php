<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RoomController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('chat');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'chat']);
    Route::get('/users', [ChatController::class, 'users']);
    
    Route::get('/user-rooms', [RoomController::class, 'rooms']);
    Route::post('rooms/create', [RoomController::class, 'create']);
    Route::post('rooms/{id}/send-message', [RoomController::class, 'sendMessage']);
    Route::get('rooms/{id}/details', [RoomController::class, 'details']);
    Route::post('rooms/{id}/add-user', [RoomController::class, 'addUser']);
    Route::post('rooms/{id}/remove-user', [RoomController::class, 'removeUser']);
    Route::post('rooms/{id}/set-role', [RoomController::class, 'setRole']);
    Route::delete('rooms/{id}/remove', [RoomController::class, 'remove']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
