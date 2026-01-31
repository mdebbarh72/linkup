<?php

namespace App\Notifications;

use App\Models\FriendRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FriendRequestReceived extends Notification
{
    use Queueable;

    public function __construct(public FriendRequest $friendRequest) {}

    public function via(object $notifiable): array
    {
        return ['database']; 
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'friend_request_received',
            'friend_request_id' => $this->friendRequest->id,
            'sender_id' => $this->friendRequest->sender_id,
            'message' => 'You received a friend request.',
        ];
    }
}
