<?php

namespace App\Http\Controllers\Web;

use App\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SessionAttendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('attendances.index');
    }
    public function show(SessionAttendance $attendance)
    {
        return view('attendances.show', [
            'attendance' => $attendance,
            'session' => $attendance->session,
            'user' => $attendance->user,
            'gym' => $attendance->session->gym,
        ]);
    }

    public function getAttendance()
    {
        // TODO: check looged in user
        // If  gym manager then:
        $gym_id = Auth::User()->role->gym_id;
        $attendances = SessionAttendance::with(['user', 'session'])->get();
        $attendanceFilter = $attendances->filter(function ($attendance) use ($gym_id) {
            return $attendance->session->gym_id == $gym_id;
        });

        return datatables()->of($attendanceFilter)->with('user', 'session')
        ->editColumn('attendance_time', function ($attendanceFilter) {
            return date("h:i a", strtotime($attendanceFilter->attendance_time));
        })
        ->editColumn('attendance_date', function ($attendanceFilter) {
            return date("F, l jS, Y", strtotime($attendanceFilter->attendance_date));
        })
        ->editColumn('gym_name', function ($attendanceFilter) {
            return $attendanceFilter->session->gym->name;
        })->toJson();

        // If  cit manager then:

        // If  admin then:
    }
}
