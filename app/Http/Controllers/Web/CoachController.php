<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coach;
use App\Gym;

use App\Http\Requests\Coach\StoreCoachRequest;

class CoachController extends Controller
{
    public function index()
    {
        return view('coaches.index', [
            'coaches' => Coach::with('gyms').all(),
        ]);
    }

    
    public function get_data_table()
    {
        return datatables()->eloquent(Coach::query())->toJson();
    }

    public function create()
    {
        $gyms = Gym::all();
        return view('coaches.create', [
            'gyms' => $gyms,
        ]);
    }
    public function store(StoreCoachRequest $request)
    {
        Coach::create($request->all());
        return redirect()->route('coaches.index');
    }


    public function show(Coach $coach)
    {
        return view('coaches.show', [
            'coach' =>$coach,
        ]);
    }
}
