<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Short extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title','user_id','status','description','file','tags'];

    protected $appends = ['key','video'];

    public function getKeyAttribute()
    {
        return $this->id.'_shorts';
    }
    public function getVideoAttribute()
    {
        return $this->file;
    }

}
