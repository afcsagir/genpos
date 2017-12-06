<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function cartItems()
    {
        return $this->hasMany('App\CartItem');
    }

    public function soldProducts()
    {
    	return $this->hasMany('App\SoldProduct');
    }
     protected $fillable = ['name'];
}
