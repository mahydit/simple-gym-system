<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Purchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Package;
use App\City;
use App\Gym;
use Cartalyst\Stripe\Stripe as CartalystStripe;
use Carbon\Carbon;
use App\Http\Requests\Purchase\PurchaseStoreRequest;
use Illuminate\Http\Request;


class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchases.index');
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $content = [
                'cities' => City::all(),
            ];
        } elseif ($user->hasRole('citymanager')) {
            $content = [
                'cities' => Auth::user()->role->city,
                'gyms' => Gym::where('city_id', '=', Auth::user()->role->city->id)->get(),
            ];
        } else {
            $content = [
                'gyms' => Auth::user()->role->gym,
            ];
        }

        $content['users'] = User::where('role_type', '=', 'App\Attendee')->get();
        $content['packages'] = Package::all();

        return view('purchases.create', $content);
    }

    public function store(PurchaseStoreRequest $request)
    {
        $package = Package::findorFail($request->package_id);

        $this->acceptPayment($request, $package);

        $payment = [
            'client_id' => $request->user_id,
            'name' => $package->name,
            'price' => $package->price,
            'gym_id' => $request->gym_id,
            'purchase_date' => Carbon::now(),
        ];
        Purchase::create($payment);
        $user = User::findOrFail($request->user_id)->role;
        $user ->update([
            'remain_sessions' => $user->remain_sessions + $package->no_sessions,
        ]);

        return redirect()->route('purchases.index');
    }
    
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
        $stripe = CartalystStripe::make(env('STRIPE_SECRET'));
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
                return Redirect::to('strips')->with('Token is not generated correctly');
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

    public function fetchPurchaseGyms(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = Gym::where($select,$value)->get();
        $output = '<option disabled selected value="">Select ' . ucfirst($dependent) . '</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        echo $output;
    }
    
    public function getPurchase()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $purchases =getAdminFilteredPurchases(); 
        }
        elseif($user->hasRole('citymanager')){
            $purchases = Purchase::with(['gym', 'user'])->get();
            return $purchases;

        }
        else
        {
        $purchases = Purchase::where('gym_id', Auth::User()->role->gym_id)
                    ->with(['gym', 'user'])
                    ->get();
            return $purchases;

        }
    
        return datatables()->of($purchases)->with('gym', 'user')
            ->editColumn('purchase_date', function ($purchases) {
                return date("F, l jS, Y", strtotime($purchases->purchase_date));
            })->toJson();
    }

    private function getAdminFilteredPurchases()
    {
        return Purchase::with(['gym', 'user'])->get();
    }
    private function getCityFilteredPurchases()
    {
        
    }
    private function getGymFilteredPurchases()
    {}
    
}
