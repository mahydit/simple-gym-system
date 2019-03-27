<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Purchase;
use App\City;
use App\Gym;


class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Chech who is logged in.
        // If gym manager:

        $gym_id = Auth::User()->role->gym_id;
        $revenue = Purchase::where('gym_id',$gym_id)->sum('price');
        return view('revenues.index',[
            'revenue'=>$revenue,
            'gym'=>Auth::User()->role->gym,
        ]);

        // TODO: Revenue of each City
        // $city_id =Auth::User()->role->city->id;
        // $filteredGyms = Gym::where('city_id',$city_id)->get('id');
        // $revenue = Purchase::whereIn('gym_id',$filteredGyms)->sum('price');
        // dd($revenue);
        
       

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
