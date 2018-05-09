<?php

namespace App\Modules\Employee\Training\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Training extends Model
{
    protected $table = 'trainings';
    protected $appends = ['users'];

    public function getUsersAttribute(){
        $records = DB::table('user_trainings')->where('training_id', $this->attributes['id'])->get(['user_id']);
        return $records;
    }

    public function getAttachmentLinkAttribute(){
        return "<a href=" . url('/') . $this->attributes['attachment'] . "></a>";
    }
}
