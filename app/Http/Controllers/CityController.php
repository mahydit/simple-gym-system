<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        return view('cities.index',[
            'cities' => City::with('countries')->get(),
        ]);
    }

    public function create(){
        return view('cities.create',[
            'countries' => Country::all()
        ]);
    }

    public function store(){

    }

    public function show(City $city){
        return view('cities.show',[
            'city' => $city
        ]);
    }

    public function edit(City $city){
        return view('cities.edit',[
            'city' => $city,
            'countries' => Country::all()
        ]);
    }

    public function destroy(City $city){
        $city->delete();
        return redirect()->route('cities.index');
    }
}
