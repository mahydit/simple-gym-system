<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GymManager extends Model
{
    protected $fillable = [

    ];
    protected $table = 'gym_managers';
    public $timestamps = false;

    public function gym(){

        return $this->belongsTo('App\Gym');

    }
}
