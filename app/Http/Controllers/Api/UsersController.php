<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Attendee\StoreAttendeeRequest;
use App\Http\Requests\Attendee\UpdateAttendeeRequest;
use App\User;
use App\Attendee;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserVerified;
use App\Http\Resources\UserResource;


class UsersController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api' , 'verified'], ['except' => ['login' , 'store' , 'notify']]);
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
            return UserResource::collection(User::where('email' , $request->email)->with('role')->get());
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
        $attendee = Attendee::create($request->only('birth_date' , 'gender'));
        $user = User::create($request->only('name' , 'email' ,'profile_img') + [
            "password" => Hash::make($request->only('password')['password']),
            "role_id" => $attendee->id,
            "role_type" => "App\Attendee",
            ]);

        $user->sendEmailVerificationNotification();

        $user->notify(new UserVerified);

        return response()->json([

            'message' => 'User Created Successfully'
        ] , 201);
    }

    public function update(User $user , UpdateAttendeeRequest $request){
        $user->update($request->only('name' , 'profile_img'));
        Attendee::findOrFail($user->role_id)->update($request->only('gender' , 'birth_date'));
    }
    
}
