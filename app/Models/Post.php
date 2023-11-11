<?php

namespace App\Models;

use Corcel\Model\Post as Corcel;
use Psy\Util\Str;

class Post extends Corcel
{
    protected $connection = 'wordpress';
    protected $postType = 'post';

    protected $with = ['thumbnail'];


    protected $appends = ['key','created_at_ago','img'];

    public function getKeyAttribute()
    {
        return $this->ID.'_'.\str()->slug($this->post_title);
    }

    public function getImgAttribute()
    {
        $image = asset('images/404.png');
        if($this?->thumbnail?->attachment){
            $image = $this?->thumbnail?->attachment?->url;
        }
        return $image;
    }

    public function getCreatedAtAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }



}
