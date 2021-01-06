<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function board()
    {
        return $this->belongsTo('App\Board');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function thana()
    {
        return $this->belongsTo('App\Thana');
    }
}
