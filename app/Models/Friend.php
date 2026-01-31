<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;

    protected $table = 'friends';

    protected $fillable = [
        'user1',
        'user2',
    ];

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2');
    }
}
