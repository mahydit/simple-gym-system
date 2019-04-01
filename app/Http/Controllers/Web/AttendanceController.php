<?php

namespace App\Http\Controllers\Web;

use App\Session;
use App\City;
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
        $user = Auth::user();
        if($user->hasRole('admin')){
            $attendanceFilter = $this->getAdminFilteredAttendance();
        }elseif($user->hasRole('citymanager')){
            $attendanceFilter = $this->getCityFilteredAttendance();
        }else{
            $attendanceFilter = $this->getGymFilteredAttendance();
        }

        return datatables()->of($attendanceFilter)->with('user', 'session')->toJson();

    }
        
    private function getGymFilteredAttendance()
    {
        $gym_id = Auth::User()->role->gym_id;
        $attendances = SessionAttendance::with(['user', 'session'])->get();
        $attendanceFilter = $attendances->filter(function ($attendance) use ($gym_id) {
            return $attendance->session->gym_id == $gym_id;
        });
        return $attendanceFilter;
    }

    private function getCityFilteredAttendance()
    {
        $attendance = SessionAttendance::with('session')->whereHas(
            'session.gym.city', function($query)
            {
                $query->where('city_manager_id', Auth::User()->id);
            }
        )->get();
        return $attendance;
    }

    public function getAdminFilteredAttendance()
    {
        $attendance = SessionAttendance::with('session.gym.city')->get();
        return $attendance;
    }
}
