<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;
use App\Http\Requests\Package\StorePackageRequest;
use App\Http\Requests\Package\EditPackageRequest;
use App\User;

class PackagesController extends Controller
{
    public function index()
    {
        // $admin = User::find(9);
        // dd($admin->getAllPermissions());
        return view('packages.index', [
            'packages' => Package::all(),
        ]);
    }
    public function get_data_table()
    {
        return datatables()->eloquent(Package::query())->toJson();
    }

    public function getPackage()
    {
        return datatables()->eloquent(Package::query())->toJson();
    }

    public function create()
    {
        return view('packages.create');
    }
    public function store(StorePackageRequest $request)
    {
        Package::create($request->all());

        return redirect()->route('packages.index');
    }


    public function show(Package $package)
    {
        return view('packages.show', [
            'package' =>$package,
        ]);
    }


    public function edit(Package $package)
    {
        return view('packages.edit', [
            'package' => $package,
        ]);
    }

    public function update(Package $package, EditPackageRequest $request)
    {
        package::find($package['id'])->update($request->all());
        return redirect()->route('packages.index');
    }
    public function destroy(Package $package)
    {
        // dd($package);
        $package->delete();
        return redirect()->route('packages.index');
    }
}
