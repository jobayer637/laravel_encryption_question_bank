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

    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function thana()
    {
        return $this->belongsTo('App\Thana');
    }

    public function upazila()
    {
        return $this->belongsTo('App\Upazila');
    }
    public function union()
    {
        return $this->belongsTo('App\Union');
    }
}
