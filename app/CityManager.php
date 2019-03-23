<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityManager extends Model
{
    protected $fillable = [
        'user_id'
    ];
    protected $table = 'city_managers';
    public $timestamps = false;

    public function city(){

        return $this->belongsTo('App\City');

    }
}
