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

    // public $primary_key= 'id';
    public function session()
    {
        return $this->belongsToMany('App\Session');
    }

    public function gym()
    {
        return $this->belongsTo('App\Gym');
    }
}
