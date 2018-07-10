<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function getAuthorAttribute(){
        $user = User::where('id', $this->attributes['user_id'])->first();
        return ucfirst($user->first_name).' '. ucfirst($user->last_name);
    }
}
