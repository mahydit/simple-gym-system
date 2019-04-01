<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'city_manager_id',
        'country_id'
    ];
    protected $table = 'cities';
    public $timestamps = false;

    public function gym()
    {
        return $this->hasMany('App\Gym');
    }

    public function cityManager()
    {
        return $this->belongsTo('App\User', 'city_manager_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}
