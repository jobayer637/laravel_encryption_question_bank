<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function institutes()
    {
        return $this->hasMany('App\Institute');
    }
}
