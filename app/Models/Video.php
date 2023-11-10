<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title','user_id','status','description','video','tags'];

    protected $appends = ['key','created_at_ago'];

    protected $with = ['user'];

    public function getCreatedAtAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getKeyAttribute()
    {
        return $this->id.'_videos';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
