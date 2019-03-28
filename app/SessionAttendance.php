<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionAttendance extends Model
{
    protected $fillable = [
        'session_id',
        'attendee_id',
        'attendance_time',
        'attendance_date'
    ];
    
    protected $table = 'sessions_attendance';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'attendee_id');
    }

    public function session()
    {
        return $this->belongsTo('App\Session', 'session_id');
    }
}
