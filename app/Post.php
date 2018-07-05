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
    public function getAuthorAttribute(){
        $user = User::where('id', $this->attributes['user_id'])->first();
        return ucfirst(str_limit($user->first_name, 1, '.')).' '. ucfirst($user->last_name);
    }
}
