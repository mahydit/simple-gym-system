<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $fillable = [
        'birth_date', 
        'gender',
        'remain_sessions',	
    ];

    protected $table = 'attendees_users';
    public $timestamps = false;
    
    public function users()
    {
        return $this->morphOne('App\User', 'role');
    }
}
