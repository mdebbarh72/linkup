<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class FeedController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $friendIds = $user->allFriends()->pluck('id');

        $posts = Post::whereIn('user_id', $friendIds)
            ->with(['user.profile', 'images', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(10);

        return view('feed', compact('posts'));
    }
}
