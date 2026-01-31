<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Session;
use App\Models\PasswordResetToken;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::created(function (User $user) {
            $user->profile()->create([
                'pseudo' => null,
                'bio' => null,
                'lien_photo' => null,
            ]);
        });
    }

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->profile && $this->profile->lien_photo) {
            $path = 'storage/' . $this->profile->lien_photo;
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function hasPendingRequestTo(User $user): bool
    {
        return $this->friendRequestsSent()->where('reciever_id', $user->id)->exists();
    }

    public function hasPendingRequestFrom(User $user): bool
    {
        return $this->friendRequestsReceived()->where('sender_id', $user->id)->exists();
    }

    public function isFriendWith(User $user): bool
    {
        return $this->friendsAsUser1()->where('user2', $user->id)->exists()
            || $this->friendsAsUser2()->where('user1', $user->id)->exists();
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function friendRequestsSent(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function friendRequestsReceived(): HasMany
    {
        return $this->hasMany(FriendRequest::class, 'reciever_id');
    }

    public function friendsAsUser1(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user1', 'user2')
            ->withTimestamps();
    }

    public function friendsAsUser2(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user2', 'user1')
            ->withTimestamps();
    }


    public function allFriends()
    {
        return $this->friendsAsUser1->merge($this->friendsAsUser2)->unique('id')->values();
    }



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    use Notifiable;


}
