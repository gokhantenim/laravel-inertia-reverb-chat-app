<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Message;

class RoomController extends Controller
{
    function create(Request $request){
        $room = new Room();
        $room->name = $request->name;
        $room->save();
        
        $room->users()->attach($request->user(), ['type' => 'admin']);
    }

    public function rooms(Request $request) {
        if($request->user()->type == 'admin'){
            return Room::all();
        }
        return $request->user()->rooms;
    }

    function sendMessage(Request $request, string $id){
        if(!$request->user()->canAccessRoom($id)){
            return abort(403);
        }

        $room = Room::find($id);

        $message = new Message();
        $message->message = $request->message;
        $message->user_id = $request->user()->id;

        $message = $room->messages()->save($message);

        $message->load(['user' => function($query){
            $query->select('id', 'name');
        }]);
    }

    function details(Request $request, $id){
        if(!$request->user()->canAccessRoom($id)){
            return abort(403);
        }

        $room = Room::find($id);
        $messages = $room
            ->messages()
            ->with(['user' => function($query){
                $query->select('id', 'name');
            }])
            ->get();
        return [
            'messages' => $messages,
            'users' => $room->users
        ];
    }

    function addUser(Request $request, string $id){
        if(!$request->user()->canManageRoom($id)){
            return abort(403);
        }

        $room = Room::find($id);
        $user = User::find($request->id);

        $room->users()->attach($user, ['type' => 'normal']);
        $user->pivot = ['type' => 'normal'];
    }

    function removeUser(Request $request, string $id){
        if(!$request->user()->canManageRoom($id)){
            return abort(403);
        }

        $room = Room::find($id);
        $user = User::find($request->id);

        $room->users()->detach($user);
    }

    function setRole(Request $request, string $id){
        if(!$request->user()->canManageRoom($id)){
            return abort(403);
        }

        $room = Room::find($id);
        $user = User::find($request->id);

        $room->users()->updateExistingPivot($user->id, ['type' => $request->type]);
    }

    function remove(Request $request, string $id){
        if(!$request->user()->canManageRoom($id)){
            return abort(403);
        }
        
        $room = Room::find($id);
        $user = User::find($request->id);

        $roomUsers = $room->users;

        $room->users()->detach();
        $room->messages()->delete();
        $room->delete();
    }
}
