<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function attemptLogin(Request $request)
    {
        // attempt to issue a token to the user based on the login credentials
        $token = $this->guard()->attempt($this->credentials($request));

        if(! $token)
        return false;

        // get the authenticatied user
            $user = $this->guard()->user();

            if( $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail())
            return false;

            //set a user token 
            $this->guard()->setToken($token);
            return true;
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        // get token from authinticatied guard  JWT
        $token  = (string)$this->guard()->getToken();

        // extract the expiry date of the token
        $expiration = $this->guard()->getPayload()->get('exp');

        return response()->json(
            [
                'token'=>$token,
                'token_type'=>'Bearer',
                'expires_it'=>$expiration,
                'user'=>$this->guard()->user(),
                

            ]
        );

    }


    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->user();
        // $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()
        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()){
            return response()->json([
                'message'=>trans('auth.must_verification_email'),
                'errors'=>['verification'=>trans('auth.must_verification_email')]

            ],422);
        }
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'message'=>trans('auth.logout_successfuly')
        ]);
    }

}
