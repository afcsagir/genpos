<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function cart()
    {
        return $this->belongsTo('App\Cart');
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