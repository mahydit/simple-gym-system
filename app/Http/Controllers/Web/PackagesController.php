<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;

class PackagesController extends Controller
{
    public function index()
    {
        return view('packages.index', [
            'packages' => Package::all(),
        ]);
    }
    public function get_data_table()
    {
        return datatables()->eloquent(Package::query())->toJson();
    }
}
