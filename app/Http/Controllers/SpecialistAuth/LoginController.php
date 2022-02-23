<?php

namespace App\Http\Controllers\SpecialistAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use App\Models\{UserLoginLog};
use App\Specialist;
use Illuminate\Validation\ValidationException;


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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/specialist/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('specialist.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('specialistApp.auth.login');
    }

    public function logoutToPath()
    {
        return '/specialist/login';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('specialist');
    }

    protected function authenticated(Request $request, $user)
    {
        if(!empty($user))
        {
            $user_login = UserLoginLog::where('user_id', $user['id'])->where('user_type', 'specialist')->orderBy('created_at','desc')->first();

            if(!empty($user_login))
            {
                  $specialist = Specialist::find($user['id']);
                  $specialist->last_login = $user_login->created_at;
                  $specialist->save();
                  UserLoginLog::create(['user_id'=>$user['id'], 'user_type' =>'specialist']);  
            }else{
               $dta =  UserLoginLog::create(['user_id'=>$user['id'], 'user_type' =>'specialist']);
               //update last login in specialist table
               if(!empty($dta)){
                  $specialist = Specialist::find($user['id']);
                  $specialist->last_login = $dta->created_at;
                  $specialist->save(); 
               }
            }
        }
    }

    /**
     * Login the Employer
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {   
        $user = null;
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request)))
        {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->status == 'active' && $this->attemptLogin($request))
            {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request,$user);
    }

    protected function sendFailedLoginResponse(Request $request,$user)
    {   
        if(isset($user->status) && $user->status == 'inactive')
        {
            throw ValidationException::withMessages([
                $this->username() => ['Your account is inactive'],
            ]);
        }   
        else
        {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }
    }
}
