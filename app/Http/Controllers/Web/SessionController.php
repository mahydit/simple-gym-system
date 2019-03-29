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
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        return view('sessions.index');
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $cities = City::all();

            $content = [
                'cities'=>$cities,
            ];
        } elseif ($user->hasRole('citymanager')) {
            $city_id = Auth::User()->role->city->id;
            $city = Auth::User()->role->city;
            $gyms = Gym::where('city_id', '=', $city_id)->get();
            
            $content = [
                'city'=>$city,
                'gyms'=>$gyms,
            ];
        } else {
            $gym_id = Auth::User()->role->gym_id;
            $gym = Auth::User()->role->gym;
            $filteredCoaches = Coach::all()->filter(function ($coach) use ($gym_id) {
                return $coach->at_gym_id == $gym_id;
            });
            
            $content = [
                'gym'=>$gym,
                'coaches'=>$filteredCoaches->all(),
            ];
        }

        return view('sessions.create', $content);
    }

    public function store(StoreSessionRequest $request)
    {
        $request['starts_at'] = date("H:i:s", strtotime($request->starts_at));
        $request['ends_at'] = date("H:i:s", strtotime($request->ends_at));
    
        $session = Session::create($request->all());
        $session->coaches()->attach($request->coach_id);

        return redirect()->route('sessions.index');
    }

    public function show(Session $session)
    {
        return view('sessions.show', [
            'session'=> $session,
            'coaches'=>$session->coaches,
            'gym'=>$session->gym,
        ]);
    }

    public function edit(Session $session)
    {
        if (!SessionAttendance::where('session_id', '=', $session->id)->exists()) {
            return view('sessions.edit', [
                'session'=> $session,
                'coaches'=>$session->coaches,
                'gym'=>$session->gym,
                'city'=>$session->gym->city,
            ]);
        } else {
            return redirect()->route('sessions.index');
        };
    }

    public function update(UpdateSessionRequest $request, $session)
    {
        $request['starts_at'] = date("H:i:s", strtotime($request->starts_at));
        $request['ends_at'] = date("H:i:s", strtotime($request->ends_at));

        Session::findOrFail($session)->update($request->all());

        return redirect()->route('sessions.index');
    }

    public function destroy($session)
    {
        if (!SessionAttendance::where('session_id', '=', $session)->exists()) {
            DB::table('sessions_coaches')->where('session_id', '=', $session)->delete();
            Session::findOrFail($session)->delete();
            return redirect()->route('sessions.index');
        } else {
            return redirect()->route('sessions.index');
        };
    }

    public function getSession()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $sessionFilter = $this->getAdminFilteredSessions();
        } elseif ($user->hasRole('citymanager')) {
            $sessionFilter = $this->getCityFilteredSessions();
        } else {
            $sessionFilter = $this->getGymFilteredSessions();
        }
        
        return datatables()->of($sessionFilter)->with(['gym','coaches'])
        ->editColumn('starts_at', function ($sessionFilter) {
            return date("h:i a", strtotime($sessionFilter->starts_at));
        })
        ->addColumn('city_name', function ($sessionFilter) {
            return City::findorFail($sessionFilter->gym->city_id)->name;
        })
        ->editColumn('ends_at', function ($sessionFilter) {
            return date("h:i a", strtotime($sessionFilter->ends_at));
        })
        ->editColumn('session_date', function ($sessionFilter) {
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

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        if ($select == 'city_id'){
            $data = Gym::where($select, $value)
                ->get();
        }else{
            $data = Coach::where('at_gym_id', $value)
                ->get();
        }
        $output = '<option value="">Select ' . ucfirst($dependent) . '</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
    }
}
