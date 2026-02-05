<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function create(CreatePostRequest $request)
    {
        $data = $request->validated();

        $post = $request->user()->posts()->create([
            'content' => $data['content'] ?? null,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');

                $post->images()->create([
                    'path' => $path,
                    'disk' => 'public',
                ]);
            }
        }

        return back()->with('success', 'Post created.');
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if (array_key_exists('content', $data)) {
            $post->content = $data['content'];
            $post->save();
        }

        if (!empty($data['remove_images']) && is_array($data['remove_images'])) {
            $images = $post->images()->whereIn('id', $data['remove_images'])->get();

            foreach ($images as $img) {
                Storage::disk($img->disk ?? 'public')->delete($img->path);
                $img->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');

                $post->images()->create([
                    'path' => $path,
                    'disk' => 'public',
                ]);
            }
        }

        $post->loadCount('images');
        $hasText = filled($post->content);
        $hasAnyImage = $post->images_count > 0;

        if (!$hasText && !$hasAnyImage) {
            return back()
                ->withErrors(['content' => 'Post must contain text or at least one image.'])
                ->withInput();
        }

        return back()->with('success', 'Post updated.');
    }

    public function delete( Post $post)
    {
        $post->load('images');

        foreach ($post->images as $img) {
            Storage::disk($img->disk ?? 'public')->delete($img->path);
            $img->delete();
        }

        $post->delete();

        return back()->with('success', 'Post deleted.');
    }
}
