<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

class GymManager extends Model implements BannableContract
{
    use Bannable;
    
    protected $fillable = [
        'gym_id',
        'SID'
    ];
    protected $table = 'gym_managers';
    public $timestamps = false;

    public function gym(){

        return $this->belongsTo('App\Gym');

    }

    public function user()
    {
        return $this->morphOne('App\User', 'role');
    }
}
