<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Coach;

class CoachController extends Controller
{
    public function index()
    {
        return view('coaches.index', [
            'coaches' => Coach::all(),
        ]);
    }

    public function get_data_table()
    {
        $coaches = Coach::select('id', 'name', 'at_gym_id');
        return Datatables::of($coaches)
        ->addColumn('action', function ($coach) {
            return 'Edit';
        })
        ->make(true);
    }
}
