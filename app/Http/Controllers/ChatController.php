<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class ChatController extends Controller
{
    public function chat(Request $request): Response
    {
        return Inertia::render('Chat');
    }

    public function users() {
        return User::all();
    }
}
