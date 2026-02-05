<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\createCommentRequest;
use App\Models\Comment;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function create(createCommentRequest $request)
    {
        $data= $request->validated();
        $comment= $request->user()->comments()->create(['post_id'=>$data['post_id'], 'body' => $data['body']]);
        return back()->with('success', 'Comment added.');
        
    }

    public function update(updateCommentRequest $request)
    {
        $data= $request->validated();
        $comment= $request->user()->comment()->save();
        return back()->with('success', 'comment updated.');
    }

    public function delete(Comment $post)
    {
        $post= auth()->user()->find($post->id);
        $post->destroy();
    }
}
