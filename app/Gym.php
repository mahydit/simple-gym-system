<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $fillable = [
        'name',
        'image',
        'created_at',
        'updated_at',
        'city_id',
        'created_by'
    ];
    protected $table = 'gyms';
    protected $dateFormat = 'U';


    public function gymManagers()
    {
        return $this->hasMany('App\GymManager');
    }

    public function coaches()
    {
        return $this->hasMany('App\Coach', 'at_gym_id');
    }

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    public function purchaseHistory()
    {
        return $this->hasMany('App\Purchase');
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
