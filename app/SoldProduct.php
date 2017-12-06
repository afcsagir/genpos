<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoldProduct extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function variance()
    {
        return $this->belongsTo('App\Variance');
    }

    public function customer() 
    {
    	return $this->belongsTo('App\Customer');
    }
}
