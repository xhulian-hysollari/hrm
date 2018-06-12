<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function images(){
        return $this->hasMany(Image::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
