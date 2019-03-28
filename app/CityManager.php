<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class CityManager extends Model
{
    use HasRoles;
    protected $guard_name = 'web';
    protected $fillable = [
        'SID'
    ];
    protected $table = 'city_managers';
    public $timestamps = false;

    public function city()
    {
        return $this->hasOne('App\City', 'city_manager_id');
    }

    public function user()
    {
        return $this->morphOne('App\User', 'role');
    }
}
