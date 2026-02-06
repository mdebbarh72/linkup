<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $user = $request->user();
        
       
        $existingLike = $post->likes()->where('user_id', $user->id)->first();
        
        if ($existingLike) {
           
            $existingLike->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
        
        return response()->json([
            'liked' => $liked,
            'count' => $post->fresh()->likes_count
        ]);
    }
}
