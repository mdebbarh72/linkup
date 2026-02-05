<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FriendController;
use Illuminate\Database\Schema\PostgresSchemaState;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('feed');
    }
    return view('landing');
});

Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/{user}/request', [FriendController::class, 'sendRequest'])->name('friends.request');
    Route::post('/friends/{requestId}/accept', [FriendController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/{requestId}/refuse', [FriendController::class, 'refuseRequest'])->name('friends.refuse');
    Route::delete('/friends/{user}/remove', [FriendController::class, 'remove'])->name('friends.remove');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/customize', [ProfileController::class, 'customize'])->name('profile.customize');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/post', [PostController::class, 'create'])->name('post.create');
    Route::match(['put', 'post'], '/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'delete'])->name('post.delete');
    Route::post('/comment', [CommentController::class, 'create'])->name('comment.create');
    Route::post('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::post('/comment/{comment}', [CommentController::class, 'delete'])->name('comment.delete');

});


require __DIR__.'/auth.php';
