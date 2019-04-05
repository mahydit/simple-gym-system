<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class CityManager extends Model
{
    use HasRoles;
    protected $guard_name = 'web';
    protected $fillable = [
        'SID',
        'city_id'
    ];
    protected $table = 'city_managers';
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\City', 'city_id');
    }

    public function user()
    {
        return $this->morphOne('App\User', 'role');
    }
}
