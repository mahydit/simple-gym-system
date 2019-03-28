<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Purchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Package;
use Illuminate\Http\Request;
use Stripe\Stripe;

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
    public function store(Request $request)
    {
        // dd($request);
        $request['gym_id'] = Auth::User()->role->gym_id;
        $package = Package::findorFail($request->package_id);
        // $package = DB::table('gym_packages')->where('name', $request->get('package_name'))->first();
        $this->acceptPayment($request, $package);
        $payment = [
            "_token" => $request->_token,
            "user_id" => $request->user_id,
            'package_name' => $request->package_name,
            'package_price' => $package->price,
            'gym_id' => $request->gym_id,
            // 'purchase_date' => Carbon\Carbon::now(),
        ];
        Purchase::create($payment);
        // return back()->with('success', 'Purchase created successfully!');
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

    private function acceptPayment($request, $package)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->card_no,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvv,
                ],
            ]);
            if (!isset($token['id'])) {
                return Redirect::to('strips')->with('Token is not generate correct');
            }
            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => $package->price,
            ]);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
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
