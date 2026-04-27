<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with(['user', 'room'])->get();
        return view('admin.comment', compact('comments'));
    }


    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }


    public function updateStatus(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Approved,Deleted',
        ]);

        $comment->update(['status' => $request->status]);

        return redirect()->route('admin.comments')->with('success', 'Comment updated!');
    }
}
