<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [

    ];
    protected $table = 'cities';
    public $timestamps = false;

    public function gym(){

        return $this->hasMany('App\Gym');

    }

    public function cityManager(){

        return $this->hasOne('App\CityManager');

    }

    public function country(){

        return $this->belongsTo('App\Country');

    }
}
