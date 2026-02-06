<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Post;

class ProfilePosts extends Component
{
    use WithPagination;

    public $userId;
    public $perPage = 10;
    public $totalPosts = 0;

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        // Get total count of available posts
        $this->totalPosts = Post::where('user_id', $this->userId)->count();

        $posts = Post::where('user_id', $this->userId)
            ->with(['user.profile', 'images', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take($this->perPage)
            ->get();

        return view('livewire.profile-posts', [
            'posts' => $posts,
            'hasMore' => $posts->count() >= $this->perPage && $this->totalPosts > $posts->count()
        ]);
    }
}
