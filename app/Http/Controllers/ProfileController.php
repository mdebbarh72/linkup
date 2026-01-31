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

    
    $user->profile->update([
        'pseudo' => $request->validated('pseudo'),
    ]);

    
    $profile = $user->profile()->firstOrCreate([]); 

    $data = [
        'bio' => $request->validated('bio'),
    ];

    
    if ($request->hasFile('lien_photo')) {
        
        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }

        $data['lien_photo'] = $request->file('lien_photo')->store('lien_photo', 'public');
    }

    $profile->update($data);

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
}
