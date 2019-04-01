<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\City;
use App\Gym;
use App\User;
use App\Session;

use App\Http\Requests\Gym\StoreGymRequest;
use App\Http\Requests\Gym\UpdateGymRequest;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gyms.index', [
            'gyms' => Gym::all(),
            'cities' => City::all(),
        ]);
    }

    public function getGym()
    {
        return datatables()->eloquent(Gym::query())->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user= auth()->user();
        if ($user->hasRole('admin')) {
            $cities = City::all();
            $gyms = Gym::all();
        } elseif ($user->hasRole('citymanager')) {
            $city = City::where('city_manager_id', auth()->user()->id)->get()->first();
            $gyms = Gym::where('city_id', $city->id)->get()->all();
            $cities = City::where('city_manager_id', auth()->user()->id)->get()->all();
        }
        return view('gyms.create', [
            'gyms' => $gyms,
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymRequest $request)
    {
        if ($request->file('image')) {
            $path = $request->file('image')->store('public/gym_managers_images');
        } else {
            $path = "public/default/default.jpeg";
        }
        Gym::create($request->all() + ['created_by' => auth()->user()->name, 'image' => 'public/default/default.jpeg']);
        return redirect()->route('gyms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gym $gym)
    {
        $user= auth()->user();
        if ($user->hasRole('admin')) {
            $cities = City::all();
            $gyms = Gym::all();
        } elseif ($user->hasRole('citymanager')) {
            $city = City::where('city_manager_id', auth()->user()->id)->get()->first();
            $gyms = Gym::where('city_id', $city->id)->get()->all();
            $cities = City::where('city_manager_id', auth()->user()->id)->get()->all();
        }
        return view('gyms.show', [
            'gyms' => $gyms,
            'cities' => $cities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Gym $gym)
    {
        return view('gyms.edit', [
            'gym' => $gym,
            'cities' => City::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGymRequest $request, Gym $gym)
    {
        $gym->update($request->all());
        return redirect()->route('gyms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($gym)
    {
        if (!(Session::where('gym_id', $gym)->exists())) {
            Gym::findOrFail($gym)->delete();
            return redirect()->route('gyms.index');
        } else {
            return redirect()->route('gyms.index');
        }
    }
}
