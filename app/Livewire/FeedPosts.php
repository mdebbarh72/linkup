<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class FeedPosts extends Component
{
    public $perPage = 10;
    public $totalPosts = 0;

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        $user = auth()->user();
        $friendIds = $user->allFriends()->pluck('id');

        // Get total count of available posts
        $this->totalPosts = Post::whereIn('user_id', $friendIds)->count();

        $posts = Post::whereIn('user_id', $friendIds)
            ->with(['user.profile', 'images', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take($this->perPage)
            ->get();

        return view('livewire.feed-posts', [
            'posts' => $posts,
            'hasMore' => $posts->count() >= $this->perPage && $this->totalPosts > $posts->count()
        ]);
    }
}
