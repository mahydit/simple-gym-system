<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coach;
use App\Gym;

use App\Http\Requests\Coach\StoreCoachRequest;
use App\Http\Requests\Coach\EditCoachRequest;

class CoachController extends Controller
{
    public function index()
    {
        return view('coaches.index', [
            'coaches' => Coach::all(),
        ]);
    }

    
    public function getCoach()
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

    public function edit(Coach $coach)
    {
        $gyms = Gym::all();
        return view('coaches.edit', [
            'coach' => $coach,
            'gyms' => $gyms,
        ]);
    }

    public function update(Coach $coach, EditCoachRequest $request)
    {
        Coach::find($coach['id'])->update($request->all());
        return redirect()->route('coaches.index');
    }

    public function destroy($id){
    }
}
