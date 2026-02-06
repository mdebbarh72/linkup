<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\CustomizeProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        return back()->with('status', 'profile-updated');
    }




public function customize(CustomizeProfileRequest $request)
{
    $user = $request->user();
    
    // Get or create profile
    $profile = $user->profile()->firstOrCreate([]); 

    // Prepare data for update, excluding the image file
    $data = $request->safe()->except(['lien_photo']);

    // Handle profile image upload
    if ($request->hasFile('lien_photo')) {
        $path = $request->file('lien_photo')->store('profiles', 'public');

        if ($profile->image) {
            // Delete old image and update with new one
            Storage::disk('public')->delete($profile->image->path);
            $profile->image->update([
                'path' => $path,
                'disk' => 'public'
            ]);
        } else {
            // Create new image record
            $profile->image()->create([
                'path' => $path,
                'disk' => 'public'
            ]);
        }
    }

    // Update profile with validated data (pseudo and/or bio if provided)
    // Only updates fields that are present in the validated data
    if (!empty($data)) {
        $profile->update(array_filter($data, fn($value) => $value !== null));
    }

    return back()->with('status', 'profile-customized');
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(\App\Models\User $user): View
    {
        $posts = $user->posts()
            ->with(['images', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(10);

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
            'friendsCount' => $user->allFriends()->count(),
            'postsCount' => $user->posts()->count(),
        ]);
    }
}
