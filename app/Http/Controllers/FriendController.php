<?php

namespace App\Http\Controllers;

use App\Services\FriendshipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function __construct(private FriendshipService $service) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $friends = $user->allFriends();
        $requests = $user->friendRequestsReceived()->with('sender.profile')->get();

        return view('friends.index', [
            'friends' => $friends,
            'requests' => $requests,
        ]);
    }

    public function sendRequest(Request $request, User $user): RedirectResponse
    {
        try {
            $this->service->sendRequest($request->user(), $user);
            return back()->with('status', 'request-sent');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function acceptRequest(Request $request, int $requestId): RedirectResponse
    {
        try {
            $this->service->acceptRequest($request->user(), $requestId);
            return back()->with('status', 'request-accepted');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function refuseRequest(Request $request, int $requestId): RedirectResponse
    {
        try {
            $this->service->rejectRequest($request->user(), $requestId);
            return back()->with('status', 'request-refused');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function remove(Request $request, int $otherUserId): RedirectResponse
    {
        $this->service->removeFriend($request->user(), $otherUserId);
        return back()->with('status', 'friend-removed');
    }
}
