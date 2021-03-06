<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
