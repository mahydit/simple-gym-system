<?php

namespace App\Http\Controllers\Web;

use App\Purchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function get_data_table()
    {
        return datatables()->eloquent(Purchase::query())->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        return view('purchases.show',[
            'purchase' =>$purchase,
            'attendee' => $purchase->user,
            'gym' => $purchase->gym,
        ]);
    }

    public function getPurchase()
    {
        // TODO: check logged in user 
        // if gym manager then :
        $purchases = Purchase::where('gym_id',Auth::User()->role->gym_id)
                    ->with(['gym', 'user'])
                    ->get();
    
        return datatables()->of($purchases)->with('gym','user')
            ->editColumn('purchase_date', function ($purchases) 
            {
                return date("F, l jS, Y", strtotime($purchases->purchase_date));
            })
            ->editColumn('price', function ($purchases) 
            {
                return $purchases->priceInDollar();

            })->toJson();
    }
}
