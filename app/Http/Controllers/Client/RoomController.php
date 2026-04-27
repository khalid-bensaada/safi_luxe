<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Comment;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function index(Request $request)
    {
        $query = Room::query();


        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('prixRoom', '<=', $request->max_price);
        }

        $rooms = $query->get();

        return view('client.rooms', compact('rooms'));
    }


    public function details($id)
    {
        $room = Room::findOrFail($id);

        $comments = Comment::with('user')
            ->where('room_id', $id)
            ->latest()
            ->get();

        return view('client.details', compact('room', 'comments'));
    }
}
