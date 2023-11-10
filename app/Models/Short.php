<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Short extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title','user_id','status','description','file','tags'];

    protected $appends = ['key','video','created_at_ago'];

    protected $with = ['user'];

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
