<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function attributes()
    {
    	return $this->hasMany('App\Attribute');
    }

    public function variances()
    {
    	return $this->hasMany('App\Variance');
    }

    public function detail()
    {
    	return $this->hasOne('App\Detail');
    }

    public function review()
    {
        return $this->hasMany('App\Review');
    }
}
