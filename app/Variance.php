<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variance extends Model
{
    public function product()
	{
		return $this->belongsTo('App\Product');
	}

	public function itemInCart()
	{
		return $this->hasMany('App\CartItem');
	}

	public function itemInList()
	{
		return $this->hasMany('App\Wishlist_Item');
	}

	public function soldProduct()
	{
		return $this->hasMany('App\SoldProduct');
	}
}
