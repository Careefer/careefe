<?php

namespace App\Http\Controllers\SpecialistAuth;

use App\Specialist;
use App\Models\FunctionalArea;
use App\Models\NotificationSetting;
use App\Models\UserNotificationSetting;
use App\Models\UserLocation;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;



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
    protected $redirectTo = '/specialist/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   

        $this->middleware('specialist.guest');
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
                'first_name'    => 'required|max:191',
                'last_name'     => 'required|max:191',
                'email'             => "required|unique:specialists,email,null,id,deleted_at,NULL|max:100",
                'phone'         => 'required|numeric|digits_between:8,15',
                'password'      => 'required|between:6,20|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'location'              => 'required|max:191',
                'functional_area'       => 'required',
                'term_and_condition'    => 'required',
                //'resume'                => 'required|max:5120'
            ],[
            'password.regex' =>  'Password must be between 6 to 20 character having one capital & small letters and one number',
            'resume.max' => 'The resume may not be greater than 5 MB'
        ]);

        if($validator->fails())
        {
            request()->session()->flash('error_notify',FORM_ERROR_MSG);
        }

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Specialist
     */
    protected function create(array $data)
    {   
        // $file_extension = request()->file('resume')->getClientOriginalExtension();
        // $file_name      = slug_url('resume-'.md5(time())).'.'.$file_extension;
        // $path          = request()->file('resume')->storeAs('public/specialist/resume',$file_name);


     $obj =  Specialist::create([
            'specialist_id' => Specialist::getNextId(),
            'name'          => $data['first_name'].' '.$data['last_name'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'location'      => $data['location'],
            'functional_area_ids' => $data['functional_area'],
           // 'resume'            =>  $file_name,
            'status'            =>  'inactive',
            'term_and_condition' =>  $data['term_and_condition'],
            'password'          =>  bcrypt($data['password']),
        ]);

        if($obj->id)
        {
             //check if current location exist
             $location = UserLocation::where(['user_id'=>$obj->id,'user_type'=>'specialist','location_type'=>'current'])->first();
             
             if(!$location)
             {
                 $location            = new UserLocation();
                 $location->user_id   = $obj->id;
                 $location->user_type = 'specialist';
                 $location->location_type    = 'current';
             }

             if(isset($data['location']) && $data['location'] > 0)
             {   
                 $location->location_id    = $data['location'];
             }

             $location->save();

             request()->session()->flash('success','You have successfully registered');
        }

        $notification_settings = NotificationSetting::where('user_type','specialist')->get();
        foreach ($notification_settings as  $notification_setting) 
        {
            $user_notification_setting = new UserNotificationSetting();
            $user_notification_setting->user_id = $obj->id;
            $user_notification_setting->notification_setting_id = $notification_setting->id;
            $user_notification_setting->user_type = 'specialist';
            $user_notification_setting->save();
        }


        return $obj;
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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {   
        $functional_area = FunctionalArea::pluck('name','id');
        
        return view('specialistApp.auth.register',compact('functional_area'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('specialist');
    }
}
