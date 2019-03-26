<?php

namespace App\Http\Controllers\Web;

use App\Gym;
use App\Coach;
use App\Session;
use App\SessionAttendance;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Session\StoreSessionRequest;
use App\Http\Requests\Session\UpdateSessionRequest;
use DB;
use DataTables;

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
        $gym = Gym::find($gym_id);
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

        Session::find($session)->update($request->all());

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
            Session::find($session)->delete();
            return redirect()->route('sessions.index');
        // } else {
            // TODO: msg saying user can't be updated.
            // return redirect()->route('sessions.index');
        // };
    }

    public function getSession()
    {
     
        // $session = Session::with(['gym','coaches']);

        // return DataTables::of($session)->with('gym','coaches')->toJson();
        $gym_id = Auth::User()->role->gym_id;
        $session = Session::with(['gym', 'coaches'])->get();
        $sessionFilter = $session->filter(function ($session) use ($gym_id) {
            return $session->gym_id == $gym_id;
        });
        return datatables()->of($sessionFilter)->with('gym','coaches')->editColumn('starts_at', function ($sessionFilter) 
        {
            return date("h:i a", strtotime($sessionFilter->starts_at));
        })
        ->editColumn('ends_at', function ($sessionFilter) 
        {
            //change over here
            return date("h:i a", strtotime($sessionFilter->ends_at));
        })
        ->editColumn('session_date', function ($sessionFilter) 
        {
            //change over here
            return date("d-M-Y", strtotime($sessionFilter->session_date));
        })->toJson();
    }

}
