<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostDetailResource;

class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'commentContents' => 'required',
        ]);

        $request['user_id'] = Auth::user()->id;

        $comment = Comment::create($request->all());

        return new CommentResource($comment->loadMissing(['comentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'commentContents' => 'required'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->only('commentContents'));

        return new CommentResource($comment->loadMissing(['comentator:id,username']));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return new CommentResource($comment->loadMissing(['comentator:id,username']));
    }
}
