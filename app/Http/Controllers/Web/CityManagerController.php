<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CityManager;
use App\City;
use App\User;
use App\Http\Requests\CityManager\StoreCityManagerRequest;
use App\Http\Requests\CityManager\UpdateCityManagerRequest;

class CityManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(CityManager::with('user')->get());
        return view('cityManagers.index',[
            'cityManagers' => CityManager::with('user')->get(),
            'cities' => City::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cityManagers.create',[
            'cityManagers' => CityManager::all(),
            'cities' => City::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityManagerRequest $request)
    {
        CityManager::create($request->all());
        return redirect()->route('cityManagers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CityManager $cityManager)
    {
        return view('cityManagers.show',[
            'cityManager' => $cityManager
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CityManager $cityManager)
    {
        return view('cityManagers.edit',[
            'cityManager' => $cityManager,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityManagerRequest $request, CityManager $cityManager)
    {
        $request->update($request->all());
        return redirect()->route('cityManagers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityManager $cityManager)
    {
        $cityManager->delete();
        return redirect()->route('cityManagers.index');
    }
}
