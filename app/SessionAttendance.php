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
}
