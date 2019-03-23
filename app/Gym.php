<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [

    ];
    protected $table = 'gyms';
    public $timestamps = false;

    public function gymManagers(){

        return $this->hasMany('App\GymManager');
    }

    public function coaches(){

        return $this->hasMany('App\Coach');

    }

    public function sessions(){

        return $this->hasMany('App\Session');

    }

    public function purchaseHistory(){

        return $this->hasMany('App\Purchase');

    }

    public function city(){

        return $this->belongsTo('App\City');

    }
}
