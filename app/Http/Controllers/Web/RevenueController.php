<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Purchase;
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
        $user = Auth::User();
        if ($user->hasRole('admin')) {
            $content = $this->calculateAdminRevene();
        } elseif ($user->hasRole('citymanager')) {
            $content = $this->calculateCityRevene();
        } else {
            $content = $this->calculateGymRevene();
        }
        return view('revenues.index', $content);
    }

    public function calculateAdminRevene()
    {
        $revenue = Purchase::all()->sum('price');
        return [
                'revenue' => $revenue,
            ];
    }

    public function calculateCityRevene()
    {
        $city_id =Auth::User()->role->city->id;
        $filteredGyms = Gym::where('city_id', $city_id)->get('id');
        $revenue = Purchase::whereIn('gym_id', $filteredGyms)->sum('price');
        return  [
            'revenue' => $revenue,
            'city' => Auth::User()->role->city,
        ];
    }

    public function calculateGymRevene()
    {
        $gym_id = Auth::User()->role->gym_id;
        $revenue = Purchase::where('gym_id', $gym_id)->sum('price');
        return [
                'revenue'=>$revenue,
                'gym'=>Auth::User()->role->gym,
            ];
    }
}
