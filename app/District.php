<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function institutes()
    {
        return $this->hasMany('App\Institute');
    }
}
