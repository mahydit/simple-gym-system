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
        // TODO: check logged in user
    
        $user = Auth::user();
        if($user->hasRole('admin')){
            $attendanceFilter = $this->getAdminFilteredAttendance();
        }elseif($user->hasRole('citymanager')){
            $attendanceFilter = $this->getCityFilteredAttendance();
        }else{
            $attendanceFilter = $this->getGymFilteredAttendance();
        }

        return datatables()->of($attendanceFilter)->with('user', 'session')
        ->editColumn('attendance_time', function ($attendanceFilter) {
            return datatables()->of($attendanceFilter)->with(['gym','coaches'])
            
            ->editColumn('starts_at', function ($attendanceFilter) 
            {
                return date("h:i a", strtotime($attendanceFilter->starts_at));
            })
            ->addColumn('city_name', function ($attendanceFilter) 
            {
                return City::findorFail($attendanceFilter->gym->city_id)->name;
    
            })
            ->editColumn('ends_at', function ($attendanceFilter) 
            {
                return date("h:i a", strtotime($attendanceFilter->ends_at));
            })
            ->editColumn('session_date', function ($attendanceFilter) 
            {
                return date("d-M-Y", strtotime($attendanceFilter->session_date));
            })->toJson();
            return date("h:i a", strtotime($attendanceFilter->attendance_time));
        })
        ->editColumn('attendance_date', function ($attendanceFilter) {
            return date("F, l jS, Y", strtotime($attendanceFilter->attendance_date));
        })
        ->editColumn('gym_name', function ($attendanceFilter) {
            return $attendanceFilter->session->gym->name;
        })->toJson();

        // ================Session=======================
        // return datatables()->of($attendanceFilter)->with(['gym','coaches'])
        // ->editColumn('starts_at', function ($attendanceFilter) 
        // {
        //     return date("h:i a", strtotime($attendanceFilter->starts_at));
        // })
        // ->addColumn('city_name', function ($attendanceFilter) 
        // {
        //     return City::findorFail($attendanceFilter->gym->city_id)->name;

        // })
        // ->editColumn('ends_at', function ($attendanceFilter) 
        // {
        //     return date("h:i a", strtotime($attendanceFilter->ends_at));
        // })
        // ->editColumn('session_date', function ($attendanceFilter) 
        // {
        //     return date("d-M-Y", strtotime($attendanceFilter->session_date));
        // })->toJson();
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
        // dd($attendance);
        return $attendance;
    }

    private function getAdminFilteredAttendance()
    {
        $attendance = SessionAttendance::with('session')->whereHas(
            'session.gym.city', function($query)
            {
                $query->where('name', City::all());
            }
        )->get();
        // dd($attendance);
        return $attendance;
    }
}
