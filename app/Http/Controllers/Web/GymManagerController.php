<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GymManager;
use App\Gym;
use App\City;
use App\User;
use App\Http\Requests\GymManager\StoreGymManagerRequest;
use App\Http\Requests\GymManager\UpdateGymManagerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class GymManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('gymManagers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gymManagers.create',[
            "gyms" => Gym::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymManagerRequest $request)
    {
        if($request->file('profile_img')){
            $path = $request->file('profile_img')->store('public/gym_managers_images');

        }
        else{
            $path = "public/default/default.jpeg";
        }
        $gym_manager = GymManager::create([ "SID" => $request->only('SID')["SID"] , "gym_id" => $request->only('gym_id')['gym_id'][0]]);
        User::create($request->only('name' , 'email') + [
            "password" => Hash::make($request->only('password')['password']),
            "role_id" => $gym_manager->id,
            "role_type" => get_class($gym_manager),
            "profile_img" => $path,
        ]);
        return redirect()->route('gymManagers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(GymManager $gymmanager)
    {
        return view('gymManagers.show',[
            'gymmanager' => $gymmanager
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(GymManager $gymManager)
    {
        return view('gymManagers.edit',[
            'gymManager' => $gymManager,
            'gyms' => Gym::all(),
            'user' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGymManagerRequest $request, GymManager $gymManager)
    {
        $request->update($request->all());
        return redirect()->route('gymManagers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(GymManager $gymmanager)
    {
        $gymmanager->delete();
        return redirect()->route('gymManagers.index');
    }

    public function get_gym_manager(){
        $gym_managers = GymManager::with('user')->get();
        return datatables()->of($gym_managers)->addColumn('profile_image' , function($gym_managers){
            $url = Storage::url($gym_managers->user->profile_img);
            return '<img src="'.$url.'" border="0" width="80" class="img-rounded" align="center" />';
        })->rawColumns(['profile_image' , 'action'])->toJson();
    }
}
