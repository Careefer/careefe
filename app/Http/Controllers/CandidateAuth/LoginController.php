<?php

namespace App\Http\Controllers\CandidateAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Candidate;
use Mail;

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


    public $redirectTo = 'candidate/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('candidate.guest', ['except' => 'logout']);

        if(request()->get('redirect'))
        {
            $this->redirectTo = decrypt(request()->get('redirect'));
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('candidateApp.auth.login');
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

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('candidate');
    }

    public function logoutToPath()
    {
        return '/candidate/login';
    }



     /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($service)
    {
        if($service=='twitter' || $service=='linkedin')
        {
            $user = Socialite::driver($service)->user();
            //dd($user);
        }   
        else
        {
            $user = Socialite::driver($service)->stateless()->user();
           // dd($user);
        }

        if(!empty($user->email))
        {

              $findUser = Candidate::where('email',$user->email)->first();
              if($findUser)
              {

                  Auth::guard('candidate')->loginUsingId($findUser->id);
                  return redirect()->to('candidate/home'); 

              }
              else
              {
                  $password = Str::random(8); 

                  $candidate_id = Candidate::getNextCandidateId();
                  $candidate = new Candidate();
                  $candidate->candidate_id = $candidate_id;
                  $candidate->name = $user->name;
                  $candidate->email = $user->email;
                  $candidate->password = bcrypt($password);
                  $candidate->social_id = $user->id;
                  $candidate->social_type = $service;
                  $candidate->status = 'active';
                  $candidate->save();
                      
                  $to_name = $user->name;
                  $to_email = $user->email;

                  $data = array('name'=>$to_name, 'password' =>$password);

                  Mail::send('email.email_to_candidate_password', $data, function($message) use ($to_name, $to_email) {
                  $message->to($to_email, $to_name)
                  ->subject('Password mail');
                  $message->from('no-reply@careefer.com','admin');
                  });
                      
                  Auth::guard('candidate')->login($candidate);
                  return redirect()->to('candidate/home');      
              }         
        }
        /*else
        {
              $findUser = Candidate::where('social_id',$user->id)->first();
              if($findUser)
              {

                  Auth::guard('candidate')->loginUsingId($findUser->id);
                  return redirect()->to('candidate/home'); 

              }
              else
              {
                  $candidate_id = Candidate::getNextCandidateId();
                  $candidate = new Candidate();
                  $candidate->candidate_id = $candidate_id;
                  $candidate->name = $user->name;
                  $candidate->social_id = $user->id;
                  $candidate->social_type = $service;
                  $candidate->status = 'active';
                  $candidate->save();

                  Auth::guard('candidate')->login($candidate);
                  return redirect()->to('candidate/home');      
              }  
        }*/

                
        

    }

}
