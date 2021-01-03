<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
