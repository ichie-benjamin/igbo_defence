<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelLike\Traits\Liker;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, Liker, Follower, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'referral',
        'country',
        'avatar',
        'phone',
        'permission',
        'email',
        'platform',
        'password',
    ];

    protected $appends = ['all_followings','followers_count','videos_count'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'permission',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
//        'password' => 'hashed',
    ];

    public function shorts(): HasMany
    {
        return $this->hasMany(Short::class);
    }

    public function getAvatarAttribute($value): string
    {
        if(!$value){
            return asset('images/logo.png');
        }
        return $value;
    }

    public function getAllFollowingsAttribute()
    {
        return $this->followings->pluck('followable_id');
    }
    public function getFollowersCountAttribute()
    {
        return $this->followers->count();
    }
    public function getVideosCountAttribute()
    {
        return $this->shorts()->count();
    }
}
