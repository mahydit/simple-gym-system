<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;
use App\Http\Requests\Package\StorePackageRequest;

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

    public function create()
    {
        return view('packages.create');
    }
    public function store(StorePackageRequest $request)
    {
        Package::insert(['name'=>$request->name,
            'price'=>($request->price)*100,
            'no_sessions'=>$request->no_sessions,
        ]);

        return redirect()->route('packages.index');
    }
}
