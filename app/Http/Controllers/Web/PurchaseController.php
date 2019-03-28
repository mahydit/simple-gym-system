<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Purchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Package;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchases.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('purchases.create', [
            'users' => User::where('role_type', '=', 'App\Attendee')->get(),
            'packages' => Package::all(),
            'gym'=> Auth::user()->role->gym,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseStoreRequest $request)
    {
        dd($request);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        return view('purchases.show', [
            'purchase' =>$purchase,
            'attendee' => $purchase->user,
            'gym' => $purchase->gym,
        ]);
    }

    
    
    public function getPurchase()
    {
        // TODO: check logged in user
        // if gym manager then :
        $purchases = Purchase::where('gym_id', Auth::User()->role->gym_id)
                    ->with(['gym', 'user'])
                    ->get();
    
        return datatables()->of($purchases)->with('gym', 'user')
            ->editColumn('purchase_date', function ($purchases) {
                return date("F, l jS, Y", strtotime($purchases->purchase_date));
            })->toJson();
    }
}
