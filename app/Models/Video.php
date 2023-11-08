<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title','user_id','status','description','video','tags'];

    protected $appends = ['key'];

    public function getKeyAttribute()
    {
        return $this->id.'_videos';
    }

}
