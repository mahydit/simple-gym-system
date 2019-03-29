<?php

namespace App\Http\Controllers\Web;

use App\Gym;
use App\Coach;
use App\Session;
use App\City;
use App\SessionAttendance;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Session\StoreSessionRequest;
use App\Http\Requests\Session\UpdateSessionRequest;
use Illuminate\Support\Facades\DB;


class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sessions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gym_id = Auth::User()->role->gym_id;
        $gym = Gym::findOrFail($gym_id);
        $coaches = Coach::all();
        $filteredCoaches = $coaches->filter(function ($coach) use ($gym_id) {
            return $coach->at_gym_id == $gym_id;
        });
        
        return view('sessions.create', [
            'gym'=>$gym,
            'coaches'=>$filteredCoaches->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSessionRequest $request)
    {
        $request['starts_at'] = date("H:i:s", strtotime($request->starts_at));
        $request['ends_at'] = date("H:i:s", strtotime($request->ends_at));
        $request['gym_id'] = Auth::User()->role->gym_id;
    
        $session = Session::create($request->all());
        $session->coaches()->attach($request->coach_id);

        return redirect()->route('sessions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Session $session)
    {
        return view('sessions.show', [
            'session'=> $session,
            'coaches'=>$session->coaches,
            'gym'=>$session->gym,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Session $session)
    {
        if (!SessionAttendance::where('session_id', '=', $session->id)->exists()) {
            return view('sessions.edit', [
                'session'=> $session,
                'coaches'=>$session->coaches,
                'gym'=>$session->gym,
            ]);
        } else {
            // TODO: msg saying user can't be updated.
            return redirect()->route('sessions.index');
        };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSessionRequest $request, $session)
    {
        $request['starts_at'] = date("H:i:s", strtotime($request->starts_at));
        $request['ends_at'] = date("H:i:s", strtotime($request->ends_at));
        $request['gym_id'] = Auth::User()->role->gym_id;

        Session::findOrFail($session)->update($request->all());

        return redirect()->route('sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($session)
    {
        // if (!SessionAttendance::where('session_id', '=', $session)->exists()) {
            DB::table('sessions_coaches')->where('session_id', '=', $session)->delete();
            Session::findOrFail($session)->delete();
            return redirect()->route('sessions.index');
        // } else {
            // TODO: msg saying user can't be updated.
            // return redirect()->route('sessions.index');
        // };
    }

    public function getSession()
    {
        $user = Auth::user();
        if($user->hasRole('admin')){
            $sessionFilter = $this->getAdminFilteredSessions();
        }elseif($user->hasRole('citymanager')){
            $sessionFilter = $this->getCityFilteredSessions();
        }else{
            $sessionFilter = $this->getGymFilteredSessions();
        }
        
        return datatables()->of($sessionFilter)->with(['gym','coaches'])
        ->editColumn('starts_at', function ($sessionFilter) 
        {
            return date("h:i a", strtotime($sessionFilter->starts_at));
        })
        ->addColumn('city_name', function ($sessionFilter) 
        {
            return City::findorFail($sessionFilter->gym->city_id)->name;

        })
        ->editColumn('ends_at', function ($sessionFilter) 
        {
            return date("h:i a", strtotime($sessionFilter->ends_at));
        })
        ->editColumn('session_date', function ($sessionFilter) 
        {
            return date("d-M-Y", strtotime($sessionFilter->session_date));
        })->toJson();
        
    }

    private function getGymFilteredSessions()
    {
        $gym_id = Auth::User()->role->gym_id;
        $session = Session::with(['gym', 'coaches'])->get();
        $sessionFilter = $session->filter(function ($session) use ($gym_id) {
            return $session->gym_id == $gym_id;
        });
    
        return $sessionFilter;
    }

    private function getCityFilteredSessions()
    {
        $city_id = Auth::User()->role->city->id;
        $session = Session::with(['gym', 'coaches'])->get();
        $sessionFilter = $session->filter(function ($session) use ($city_id) {
            return $session->gym->city->id == $city_id;
        });

        return $sessionFilter;
    }

    private function getAdminFilteredSessions()
    {
        $sessions = Session::with(['gym', 'coaches'])->get();
        
        return $sessions;
    }
}
