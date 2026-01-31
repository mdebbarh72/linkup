<?php

namespace App\Services;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class FriendshipService
{
    private function canonicalPair(int $a, int $b): array
    {
        return $a < $b ? [$a, $b] : [$b, $a];
    }

    public function areFriends(int $a, int $b): bool
    {
        [$u1, $u2] = $this->canonicalPair($a, $b);

        return Friend::query()
            ->where('user1', $u1)
            ->where('user2', $u2)
            ->exists();
    }

    public function hasPendingRequest(int $senderId, int $receiverId): bool
    {
        return FriendRequest::query()
            ->where('sender_id', $senderId)
            ->where('reciever_id', $receiverId)
            ->exists();
    }

    public function sendRequest(User $sender, User $receiver): FriendRequest
    {
        if ($sender->id === $receiver->id) {
            throw new \InvalidArgumentException("You can't send a request to yourself.");
        }

        if ($this->areFriends($sender->id, $receiver->id)) {
            throw new \InvalidArgumentException('You are already friends.');
        }

        // If receiver already sent a request to sender, accept it instead (optional UX)
        $reverse = FriendRequest::query()
            ->where('sender_id', $receiver->id)
            ->where('reciever_id', $sender->id)
            ->first();

        if ($reverse) {
            $this->acceptRequest($sender, $reverse->id);
            // Create a "fake" object for response clarity is optional; simplest:
            return $reverse->fresh();
        }

        if ($this->hasPendingRequest($sender->id, $receiver->id)) {
            throw new \InvalidArgumentException('Friend request already sent.');
        }

        return FriendRequest::create([
            'sender_id' => $sender->id,
            'reciever_id' => $receiver->id,
        ]);
    }

    public function cancelRequest(User $sender, int $requestId): void
    {
        $fr = FriendRequest::query()
            ->whereKey($requestId)
            ->where('sender_id', $sender->id)
            ->first();

        if (!$fr) {
            throw new ModelNotFoundException('Request not found.');
        }

        $fr->delete();
    }

    public function rejectRequest(User $receiver, int $requestId): void
    {
        $fr = FriendRequest::query()
            ->whereKey($requestId)
            ->where('reciever_id', $receiver->id)
            ->first();

        if (!$fr) {
            throw new ModelNotFoundException('Request not found.');
        }

        $fr->delete();
    }

    public function acceptRequest(User $receiver, int $requestId): void
    {
        DB::transaction(function () use ($receiver, $requestId) {
            $fr = FriendRequest::query()
                ->lockForUpdate()
                ->whereKey($requestId)
                ->where('reciever_id', $receiver->id)
                ->first();

            if (!$fr) {
                throw new ModelNotFoundException('Request not found.');
            }

            // create friendship
            [$u1, $u2] = $this->canonicalPair($fr->sender_id, $fr->reciever_id);

            Friend::firstOrCreate([
                'user1' => $u1,
                'user2' => $u2,
            ]);

            // remove any pending requests between them in either direction
            FriendRequest::query()
                ->where(function ($q) use ($fr) {
                    $q->where('sender_id', $fr->sender_id)->where('reciever_id', $fr->reciever_id);
                })
                ->orWhere(function ($q) use ($fr) {
                    $q->where('sender_id', $fr->reciever_id)->where('reciever_id', $fr->sender_id);
                })
                ->delete();
        });
    }

    public function removeFriend(User $user, int $otherUserId): void
    {
        if ($user->id === $otherUserId) {
            return;
        }

        [$u1, $u2] = $this->canonicalPair($user->id, $otherUserId);

        Friend::query()
            ->where('user1', $u1)
            ->where('user2', $u2)
            ->delete();
    }
}
