<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
