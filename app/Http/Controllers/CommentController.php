<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        $comment = Comment::where('commentable_id', $request->commentable_id)->where('commentable_type', $request->commentable_type)->orderBy('created_at', 'desc')->get();

        return $comment;
    }

    public function store(Request $request)
    {
        $request['user_id'] = auth()->user()->id;
        $comment = Comment::create($request->all());

        return ['message' => 'Comment has been added', 'data' => $comment];
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return ['message' => 'Comment has been deleted', 'data' => $comment];
    }
}
