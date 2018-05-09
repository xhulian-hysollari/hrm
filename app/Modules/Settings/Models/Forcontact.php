<?php

namespace App\Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Forcontact extends Model
{
    protected $table = 'forcontact';
    protected $guarded = ['id'];
    protected $appends = ['parent_name'];

    public function getParentNameAttribute(){
        if($this->attributes['parent_id'] && $this->attributes['parent_id'] != ""){
            return Forcontact::where('id', $this->attributes['parent_id'])->first()->company_name;

        }
        return "";
    }
}
