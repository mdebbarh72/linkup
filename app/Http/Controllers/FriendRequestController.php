<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\FriendRequestReceived;
use App\Services\FriendshipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function __construct(private FriendshipService $service) {}

    public function send(Request $request, User $user): RedirectResponse
    {
        $sender = $request->user();

        try {
            $fr = $this->service->sendRequest($sender, $user);

            
            if ($fr->reciever_id === $user->id && $sender->id !== $user->id) {
                $user->notify(new FriendRequestReceived($fr));
            }

            return back()->with('status', 'friend-request-sent');
        } catch (\Throwable $e) {
            return back()->withErrors(['friend_request' => $e->getMessage()]);
        }
    }

    public function cancel(Request $request, int $requestId): RedirectResponse
    {
        try {
            $this->service->cancelRequest($request->user(), $requestId);
            return back()->with('status', 'friend-request-cancelled');
        } catch (\Throwable $e) {
            return back()->withErrors(['friend_request' => $e->getMessage()]);
        }
    }

    public function accept(Request $request, int $requestId): RedirectResponse
    {
        try {
            $this->service->acceptRequest($request->user(), $requestId);
            return back()->with('status', 'friend-request-accepted');
        } catch (\Throwable $e) {
            return back()->withErrors(['friend_request' => $e->getMessage()]);
        }
    }

    public function reject(Request $request, int $requestId): RedirectResponse
    {
        try {
            $this->service->rejectRequest($request->user(), $requestId);
            return back()->with('status', 'friend-request-rejected');
        } catch (\Throwable $e) {
            return back()->withErrors(['friend_request' => $e->getMessage()]);
        }
    }
}
