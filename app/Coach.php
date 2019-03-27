<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $fillable = [
        'name',
        'at_gym_id'
    ];
    protected $table = 'coaches';
    public $timestamps = false;

    public function session()
    {
        return $this->belongsToMany('App\Session', 'sessions_coaches', 'session_id', 'coach_id');
    }

    public function gym()
    {
        return $this->belongsTo('App\Gym', 'at_gym_id');
    }
}
