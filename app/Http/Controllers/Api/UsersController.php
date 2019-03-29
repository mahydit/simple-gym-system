<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendee\StoreAttendeeRequest;
use App\Http\Requests\Attendee\UpdateAttendeeRequest;
use App\User;
use App\Attendee;
use App\Purchase;
use App\Package;
use App\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\UserResource;
use App\Http\Resources\RemainingSessionResource;
use App\Http\Requests\Session\AttendSessionRequest;
use App\SessionAttendance;
use Carbon\Carbon;
use App\Http\Resources\AttendanceHistoryResource;



class UsersController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $this->guard()->user()->update(["last_log_in" => Carbon::now()->toDateTimeString()]);
            return new UserResource(User::where('email' , $request->email)->with('role')->get() , $token);
        }        
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    public function store(StoreAttendeeRequest $request){  

        $path = $request->file('profile_img')->store('public/attendees_profile_images');
        $attendee = Attendee::create($request->only('birth_date' , 'gender'));
        $user = User::create($request->only('name' , 'email') + [
            "password" => Hash::make($request->only('password')['password']),
            "role_id" => $attendee->id,
            "role_type" => get_class($attendee),
            "profile_img" => $path,
            ]);

        $user->sendEmailVerificationNotification();

        return response()->json([

            'message' => 'User Created Successfully'
        ] , 201);
    }

    public function update(UpdateAttendeeRequest $request){
        $user = Auth::user();
        if($request->only('profile_img')){
            $path = $this->update_profile_img($request);
            $user->update(['profile_img' => $path]);
        }
        $user->update($request->only('name'));
        Attendee::findOrFail($user->role_id)->update($request->only('gender' , 'birth_date'));

        return response()->json([

            'message' => 'User Updated Successfully'
        ] , 200);
    }

    private function update_profile_img($request){
        Storage::delete(Auth::user()->profile_img);
        return $request->file('profile_img')->store('public/attendees_profile_images');
    }

    public function show(){
        $user = Auth::user();
        return new RemainingSessionResource($user->with('role')->find($user->id) , Package::where('name' ,
        Purchase::where('client_id' , $user->id)->first()->name)->first()->no_sessions);
    }

    public function attend(Session $session ,AttendSessionRequest $request){
        Attendee::where('id' , Auth::user()->role_id)->decrement('remain_sessions');
        SessionAttendance::create([
            "session_id" => $session->id,
            "attendee_id" => Auth::user()->role_id,
            "attendance_time" => Carbon::now()->toTimeString(),
            "attendance_date" => Carbon::now()->toDateString(),
        ]);

        return response()->json([

            'message' => 'Session Attended'
        ] , 201);
    }

    public function history(){
        return AttendanceHistoryResource::collection(Auth::user()->sessionAttendance);
    }
    
}
