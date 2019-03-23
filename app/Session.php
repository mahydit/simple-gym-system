<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'name',	'starts_at', 'ends_at', 'gym_id', 'session_date'
    ];

    public $timestamps = false;

    public function coach(){
        
        return $this->belongsToMany('App\Coach','sessions_coaches', 'session_id','coach_id');
    }

    public function gym(){

        return $this->belongsTo('App\Gym');

    }
}
