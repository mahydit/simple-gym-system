<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CityManager;
use App\City;
use App\User;
use App\Http\Requests\CityManager\StoreCityManagerRequest;
use App\Http\Requests\CityManager\UpdateCityManagerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class CityManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cityManagers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cityManagers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityManagerRequest $request)
    {
        if ($request->file('profile_img')) {
            $path = $request->file('profile_img')->store('public/gym_managers_images');
        } else {
            $path = "public/default/default.jpeg";
        }
        $city_manager = CityManager::create($request->only('SID'));
        User::create($request->only('name', 'email') + [
            "password" => Hash::make($request->only('password')['password']),
            "role_id" => $city_manager->id,
            "role_type" => get_class($city_manager),
            "profile_img" => $path,
    
            ])->assignRole('citymanager')->givePermissionTo(['create gym','create gym manager','create coach','create session',

            'edit gym manager','edit gym','edit coach','edit session',

            'delete gym manager','delete gym','delete coach','delete session',

            'retrieve gym manager','retrieve gym','retrieve coach','retrieve package',

            'retrieve session','retrieve attendance','buy package','assign coach']);

        return redirect()->route('cityManagers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CityManager $citymanager)
    {
        return view('cityManagers.show', [
            'citymanager' => $citymanager,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CityManager $citymanager)
    {
        return view('cityManagers.edit', [
            'city_manager' => $citymanager,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityManagerRequest $request, CityManager $citymanager)
    {
        if ($request->only('profile_img')) {
            $path = $this->update_profile_img($request, $citymanager);
            $citymanager->user->update(['profile_img' => $path]);
        }
        $citymanager->user->update($request->only('name'));
        return redirect()->route('cityManagers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CityManager $citymanager)
    {
        $citymanager->delete();
        return redirect()->route('cityManagers.index');
    }

    public function get_city_manager()
    {
        $city_managers = CityManager::with('user')->get();
        return datatables()->of($city_managers)->addColumn('profile_image', function ($city_managers) {
            $url = Storage::url($city_managers->user->profile_img);
            return '<img src="'.$url.'" border="0" width="80" class="img-rounded" align="center" />';
        })->rawColumns(['profile_image' , 'action'])->toJson();
    }


    private function update_profile_img($request, CityManager $citymanager)
    {
        Storage::delete($citymanager->profile_img);
        return $request->file('profile_img')->store('public/city_managers_images');
    }
}
