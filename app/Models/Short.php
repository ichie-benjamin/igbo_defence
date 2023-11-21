<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Overtrue\LaravelLike\Traits\Likeable;

class Short extends Model
{
    use HasFactory, HasUuids, Likeable;


    protected $fillable = ['title','user_id','status','description','file','tags'];

    protected $appends = ['key','video','created_at_ago','view_count','likes'];

    protected $with = ['user'];

    public function getViewCountAttribute()
    {
        return $this->views;
    }

    public function getLikesAttribute()
    {
        return $this->totalLikers;
    }

    public function getCreatedAtAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getKeyAttribute()
    {
        return $this->id.'_shorts';
    }
    public function getVideoAttribute()
    {
        return $this->file;
    }

}
