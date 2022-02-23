<?php

namespace App\Http\Controllers\EmployerAuth;

use App\Employer;
use App\Models\EmployerDetail;
use App\Models\Employer_branch_office;
use App\Models\NotificationSetting;
use App\Models\UserNotificationSetting;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\WorldLocation;
use App\Mail\EmployerSignupEmail;
use Mail;


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
    protected $redirectTo = '/employer/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('employer.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $custom_error_msg = [];

        $rules = [
                    'company_name'   => "required|unique:employer_detail,company_name,null,id,deleted_at,NULL|max:191",
                    'head_office'    => 'required|max:191',            
                    'industry_id'    => 'required', 
                    'company_size'   => 'required',          
                    'term_and_condition'   => 'required'          
                ];

         $custom_error_msg["industry_id.required"] = "The industry field is required";       

        foreach (request()->get('temp') as $key => $value)
        {
            $rules["location_id_$key"] = "required";
            $custom_error_msg["location_id_$key.required"] ="The branch location field is required"; 
        }

        foreach (request()->get('temp2') as $key2 => $value2)
        {
            $rules["email_$key2"] = "required|email|unique:employers,email,null,id,deleted_at,NULL|max:191";
            $custom_error_msg["email_$key2.required"] ="The email field is required";
            $custom_error_msg["email_$key2.email"] ="The email must be a valid email address"; 
            $custom_error_msg["email_$key2.max"] ="The email may not be greater than 191 characters.";

            $custom_error_msg["email_$key2.unique"] = "The email has already been taken.";
        }

        $validator = Validator::make($data,$rules,$custom_error_msg);

        if($validator->fails())
        {   
            echo json_encode(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);
            exit;
        }
        else
        {
           return $validator; 
        }
    }

    private function create_branches($company_id)
    {
        $post = request()->all();

        foreach ($post as $input_name => $location_id)
        {   
            if (strpos($input_name, "location_id_") === 0)
            {
                $country_id = WorldLocation::select('country_id')->where(['id'=>$location_id,'status'=>'active'])->orderBy('id','desc')->value('country_id');

                $insert_arr[] = ['employer_id'=>$company_id,'location_id'=>$location_id,'country_id'=>$country_id];
            }
        }
        Employer_branch_office::insert($insert_arr); 
    }

    private function create_associated_account($company_id)
    {
        $post = request()->all();

        $password = [];

        foreach ($post as $input_name => $email_id)
        {   
            if(strpos($input_name, "email_") === 0)
            {
                $password = randomPassword();
                
                $insert_arr = ['company_id'=>$company_id,'email'=>$email_id,'status'=>'inactive','term_and_condition'=>$post['term_and_condition'],'password'=>bcrypt($password)];

                $u_obj = Employer::create($insert_arr);

                if($u_obj->id)
                {
                    $notification_settings = NotificationSetting::where('user_type','employer')->get();
                    foreach ($notification_settings as  $notification_setting) 
                    {
                        $user_notification_setting = new UserNotificationSetting();
                        $user_notification_setting->user_id = $u_obj->id;
                        $user_notification_setting->notification_setting_id = $notification_setting->id;
                        $user_notification_setting->user_type = 'employer';
                        $user_notification_setting->save();
                    }

                    $details['email']       = $email_id;
                    $details['password']    = $password;
                    $details['url'] = route('employer.login');

                    //dispatch(new \App\Jobs\EmployerSignupEmailJob($details));

                    Mail::send('emails.employer', ["details" => $details],function($message) use ($email_id) {
                        $message->to($email_id)->subject('Account Details');
                        //$message->from('no-reply@ldemedicalrecord.com','admin');
                    }); 
                }
            }
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Employer
     */
    protected function create(array $data)
    {   
        // try
        // {
            $post = request()->all();

            // create company first
            $company_arr = [];    

            $company_arr['employer_id']             = Employer::getNextEmployerId();
            $company_arr['company_name']            = $post['company_name'];
            $company_arr['slug']                    = slug_url($post['company_name']);
            $company_arr['head_office_location_id'] = $post['head_office'];
            $company_arr['industry_id']             = $post['industry_id'];
            $company_arr['size_of_company']         = $post['company_size'];
            $company_arr['status']                  = 'inactive';

            $obj = EmployerDetail::create($company_arr);

            if($obj->id)
            {
                $company_id = $obj->id;

                // create branch
                $this->create_branches($company_id);
                // create associated account
                $this->create_associated_account($company_id);

                die(json_encode(['status'=>'success','msg'=>'You have successfully signed up with careefer. Your application is in review']));

            }
            else
            {
                die(json_encode(['status'=>'failed','msg'=>SERVER_ERR_MSG]));
            }
        // }
        // catch(Exception $e)
        // {
        //     die(json_encode(['status'=>'failed','msg'=>'Unexpected error occurred while trying to process your request']));
        // }   
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    { 
        $industries = \App\Models\Industry::orderBy('name')->where('status','active')->pluck('name','id');

        return view('employerApp.auth.register',compact('industries'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('employer');
    }
}
