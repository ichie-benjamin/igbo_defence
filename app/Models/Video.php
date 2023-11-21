<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Overtrue\LaravelLike\Traits\Likeable;

class Video extends Model
{
    use HasFactory, HasUuids, Likeable;

    protected $fillable = ['title','user_id','status','description','video','tags'];

    protected $appends = ['key','created_at_ago','view_count','likes'];

    protected $with = ['user'];

    public function getCreatedAtAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getLikesAttribute()
    {
        return $this->totalLikers;
    }

    public function getKeyAttribute()
    {
        return $this->id.'_videos';
    }

    public function getViewCountAttribute()
    {
        return $this->views;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
