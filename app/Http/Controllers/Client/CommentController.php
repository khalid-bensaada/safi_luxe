<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'room_id'    => 'required|exists:rooms,id',
            'contentCom' => 'required|string|max:1000',

        ]);

        Comment::create([
            'user_id'    => Auth::id(),
            'room_id'    => $request->room_id,
            'contentCom' => $request->contentCom,
            'rankCom'    => $request->rankCom,
        ]);

        return back()->with('success', 'Comment added! Waiting for approval.');
    }
}
