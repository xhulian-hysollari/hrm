<?php

namespace App\Modules\Visitor\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = ['id'];
    protected $table = 'visitors';
}
