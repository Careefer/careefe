<?php

namespace App\Http\Controllers\CandidateAuth;

use App\Candidate;
use App\Models\NotificationSetting;
use App\Models\UserNotificationSetting;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/candidate/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('candidate.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $validator =  Validator::make($data, [
            'first_name' 	=> 'required|max:100',
            'last_name' 	=> 'required|max:100',
            'phone' 		=> 'required|numeric|digits_between:8,15',
            'email'             => "required|unique:candidates,email,null,id,deleted_at,NULL|max:100",
            'term_and_condition'    => 'required',
            'password'      => 'required|between:6,20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            
        ],['password.regex'=>'Password must be between 6 to 20 character having one capital & small letters and one number']);

        if($validator->fails())
        {
            request()->session()->flash('error_notify',FORM_ERROR_MSG);
        }

        return $validator;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //$this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Candidate
     */
    protected function create(array $data)
    {   
        $candidate_id = Candidate::getNextCandidateId();

        $candidate =  Candidate::create([
            'candidate_id'  => $candidate_id,
            'name'          => $data['first_name'].' '.$data['last_name'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'status'        => 'active',
            'term_and_condition' =>  $data['term_and_condition'],
            'password'      => bcrypt($data['password']),
        ]);

        $notification_settings = NotificationSetting::where('user_type','candidate')->get();
        foreach ($notification_settings as  $notification_setting) 
        {
            $user_notification_setting = new UserNotificationSetting();
            $user_notification_setting->user_id = $candidate->id;
            $user_notification_setting->notification_setting_id = $notification_setting->id;
            $user_notification_setting->user_type = 'candidate';
            $user_notification_setting->save();
        }

        request()->session()->flash('success','You have successfully registered');
        Auth::guard('candidate')->login($candidate);
        return redirect()->to('candidate/home');   
        //return  $candidate;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('candidateApp.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('candidate');
    }
}
