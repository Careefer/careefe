<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Specialist;
use App\Models\UserLocation as UserLocation;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Designation;
use App\Models\skill;
use App\Models\FunctionalArea;
use Validator;
use App\Http\Controllers\SendNotificationController;
use DB;


class AccountSettingController extends Controller
{   
    public $data;
    /**
     * Show the application's account setting form.
     *
     * @return \Illuminate\Http\Response
     */
    public function account_setting()
    {   
        my_detail();
        return view('specialistApp.account_setting');
    }

    /**
     * Show the application's account change password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        try
        {
            $request->validate([
                'existing_password'     => 'required',
                'new_password'          => 'required|min:6|max:30|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirm_password'      => 'required|same:new_password'
            ],[
            'new_password.regex' =>  'Password must be between 6 to 30 character having one capital & small letters and one number',
            ]);

            $password = auth()->user()->password;

            $input           = $request->all();
            $current_pass    = $input['existing_password'];
            $new_pass        = bcrypt($input['new_password']); 
            $confirm_pass    = $input['confirm_password'];

            if (!(Hash::check($current_pass, $password))) {
                return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }

            if((Hash::check($input['new_password'], $password)) == true){
                return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            }

            //Change Password
            $user = Auth::user();
            $user->password = $new_pass;
            $user->save(); 

            return redirect()->back()->with("success","Password has been changed Successfully.");
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }

    /**
     * view my profile
     */
    public function my_profile()
    {   
        $this->data['countries'] = Country::orderBy('name','asc')->where('status','active')->pluck('name','id');

        $this->data['profile_data'] = Specialist::findOrfail(auth()->user()->id);

        if(optional($this->data['profile_data']->current_location)->id)
        {   
            $c_id = $this->data['profile_data']->current_location->location_id;
            $this->data['c_location'] = Specialist::get_location_by_id($c_id);
        }

        if(optional($this->data['profile_data']->permanent_location)->id)
        {   
            $p_id = $this->data['profile_data']->permanent_location->location_id;
            $this->data['p_location'] = Specialist::get_location_by_id($p_id);
        }

        $this->data['designations'] = Designation::where('status','active')->pluck('name','id');

        $this->data['skills'] = skill::where('status','active')->pluck('name','id');

        $this->data['functional_area'] = FunctionalArea::where('status','active')->pluck('name','id');

        $this->data['obj_state'] = new State;
        $this->data['obj_city'] = new City;

        return view('specialistApp.profile',$this->data);
    }


    private function update_location()
    {       
        $post = request()->all();

        $user_id = auth()->user()->id;

        //check if current location exist
        $objc = UserLocation::where(['user_id'=>$user_id,'user_type'=>'specialist','location_type'=>'current'])->first();
        
        if(!$objc)
        {
            $objc            = new UserLocation();
            $objc->user_id   = $user_id;
            $objc->user_type = 'specialist';
            $objc->location_type    = 'current';
        }

        if(isset($post['c_location_id']) && $post['c_location_id'] > 0)
        {   
            $objc->location_id    = $post['c_location_id'];
        }

        $objc->zip_code      = $post['c_zip_code'];
        $objc->address       = $post['c_address'];
        $objc->save();

        // check if permanent location exist
        $objP = UserLocation::where(['user_id'=>$user_id,'user_type'=>'specialist','location_type'=>'permanent'])->get()->first();
        if(!$objP)
        {
            $objP            = new UserLocation();
            $objP->user_id   = $user_id;
            $objP->user_type = 'specialist';
            $objP->location_type    = 'permanent';
        }

        if(isset($post['p_location_id']) && $post['p_location_id'] > 0)
        {   
            $objP->location_id    = $post['p_location_id'];
        }

        $objP->zip_code      = $post['p_zip_code'];
        $objP->address       = $post['p_address'];

        $objP->save();
    }

    private function update_career_history()
    {
        $post       = request()->all();
        $insert_arr = [];
        $user_id = auth()->user()->id;
        if($post['company'])
        {
            foreach ($post['company'] as $key => $company_name)
            {   
                $job_skills_ids = null;

                if(isset($post["job_skills_$key"]))
                {
                    $job_skills_ids = implode(',', $post["job_skills_$key"]);
                }  

                $arr = [];
                $arr['user_id']         = $user_id;
                $arr['user_type']       = 'specialist';
                $arr['company_name']    = $company_name; 

                if(isset($post['designation'][$key]))
                {
                    $arr['designation_id']  = $post['designation'][$key];
                }

                if(isset($post['job_location_id'][$key]))
                {
                    $arr['location_id'] = $post['job_location_id'][$key];
                }

                $arr['job_skill_ids']   = $job_skills_ids; 

                if(isset($post['roles_responsibilities'][$key]))
                {
                    $arr['roles_responsibilities']    = $post['roles_responsibilities'][$key]; 
                }

                $arr['start_date'] = null;

                if(isset($post['job_start_date'][$key]))
                {
                    $arr['start_date']    = get_date_db_format($post['job_start_date'][$key]); 
                }

                $arr['end_date'] = null;
                if(isset($post['job_end_date'][$key]))
                {
                    $arr['end_date']    = get_date_db_format($post['job_end_date'][$key]); 
                }

                if(isset($post['key_achievements'][$key]))
                {
                $arr['key_achievements']    = $post['key_achievements'][$key];
                }

                if(isset($post['currently_working'][$key]))
                {
                    $arr['is_current_company'] = 'yes';
                }
                else
                {
                    $arr['is_current_company'] = 'no';
                }

                $arr['additional_information']    = $post['additional_information'][$key];
                $arr['created_at'] =  GMT_DATE_TIME;
                $arr['updated_at'] =  GMT_DATE_TIME;

                $insert_arr[] = $arr;
            }

            // delete existing
            DB::table('user_career_history')->where(['user_id'=>$user_id,'user_type'=>'specialist'])->delete();

            // create new fresh
            DB::table('user_career_history')->insert($insert_arr);
        }
    }

    private function update_education_history()
    {   
        try
        {
            $post       = request()->all();
            $insert_arr = [];
            $user_id    = auth()->user()->id;

            if($post['qualification'])
            {
                foreach ($post['qualification'] as $edu_key => $qualification)
                {
                    $arr = [];
                    $arr['user_id']         = $user_id;
                    $arr['user_type']       = 'specialist';
                    $arr['qualification']   = $qualification;

                    if(isset($post['course'][$edu_key]))
                    {
                        $arr['course']  = $post['course'][$edu_key];
                    }

                    if(isset($post['institute'][$edu_key]))
                    {
                        $arr['institute'] = $post['institute'][$edu_key];
                    }

                    if(isset($post['degree'][$edu_key]))
                    {
                        $arr['degree']  = $post['degree'][$edu_key];
                    }

                    if(isset($post['grade'][$edu_key]))
                    {
                        $arr['grade'] = $post['grade'][$edu_key];
                    }

                    if(isset($post['grade_data'][$edu_key]))
                    {
                        $arr['grade_data'] = $post['grade_data'][$edu_key];
                    }

                    if(isset($post['edu_country_ids'][$edu_key]))
                    {
                        $arr['country_id'] = $post['edu_country_ids'][$edu_key];
                    }

                    if(isset($post['edu_state_ids'][$edu_key]))
                    {
                        $arr['state_id'] = $post['edu_state_ids'][$edu_key];
                    }

                    if(isset($post['edu_city_ids'][$edu_key]))
                    {
                        $arr['city_id'] = $post['edu_city_ids'][$edu_key];
                    }

                    $arr['start_date']  = null;

                    if($post['edu_start_date'][$edu_key])
                    {
                        $arr['start_date']    = get_date_db_format($post['edu_start_date'][$edu_key]); 
                    }

                    $arr['end_date'] = null;
                    if($post['edu_end_date'][$edu_key])
                    {
                        $arr['end_date']    = get_date_db_format($post['edu_end_date'][$edu_key]); 
                    }
                    
                    if(isset($post['currently_pursuing'][$edu_key]))
                    {
                        $arr['currently_pursuing'] = 'yes';
                    }
                    else
                    {
                        $arr['currently_pursuing'] = 'no';
                    }

                    $arr['specialization']    = $post['specialization'][$edu_key];
                    $arr['created_at'] =  GMT_DATE_TIME;
                    $arr['updated_at'] =  GMT_DATE_TIME;
                    $insert_arr[] = $arr;                
                }
                // delete existing 
                db::table('user_education_history')->where(['user_id'=>$user_id,'user_type'=>'specialist'])->delete();
                // insert new fresh
                DB::table('user_education_history')->insert($insert_arr);
            }
        }
        catch(Exception $e)
        {

        }
    }

    public function upload_resume()
    {   
        $obj = request()->file('resume2');
        $get = request()->all();

        $file_name = false;

        if($obj)
        {
            $file_extension = request()->file('resume2')->extension();
            $file_name = 'resume_'.auth()->user()->id.'_'.time().'.'.$file_extension;

            $resume_extensions = array("pdf", "doc", "docx");
            if(in_array($file_extension, $resume_extensions))
            {
                $file = request()->file('resume2');
                $path = public_path().'/storage/specialist/resume';
                $file->move($path, $file_name);

                $my_detail = my_detail();
                    
                if($my_detail->resume) // delete existing
                {       
                    if(file_exists($path.'/'.$my_detail->resume))
                    {
                        unlink(storage_path('app/public/specialist/resume/'.$my_detail->resume));
                    }
                }    

                // manage drag
                if(isset($get['drag']) && $get['drag'] == true) 
                {
                    if(file_exists($path.'/'.$file_name))
                    {
                        if($my_detail)
                        {
                            $my_detail->resume = $file_name;
                            $my_detail->save();
                        }
                    }
                }
            }       
        }

        return $file_name;
    }

    /**
     * validate profile form
     */
    private function validate_form()
    {
        $custom_error_msg = [];
        $post = request()->all(); 

        $rules = [
                        'name'           => 'required|max:100',
                        'official_email' => 'email|max:100',
                        'phone'          => 'numeric|digits_between:8,15',
                        'resume2'        => 'max:5120|mimes:doc,pdf,docx,zip' //5mb
                ];

                $custom_error_msg = [
                                    'official_email.email' => 'The  work email must be a valid email address.',
                                    'resume2.max' => 'Size of file should not be more than 5MB.',
                                    'resume2.mimes'=>'The resume must be a file of type: doc, pdf, docx, zip.'
                                ];

        $validator  = Validator::make($post,$rules,$custom_error_msg);


        if($validator->fails())
        {    
            return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);
        }
    }

    /**
     * update user profle
     */
    public function update_profile()
    {   
        $post = request()->all(); 

        $resp = $this->validate_form();
        
        if($resp)
        {
            return $resp;
        }

        $obj_user = Specialist::find(auth()->user()->id);
        $obj_user->name             = $post['name'];
        $obj_user->official_email   = $post['official_email'];
        $obj_user->phone            = $post['phone'];
        $obj_user->profile_summary  = $post['profile_summary'];

        if(isset($post['skills']))
        {   
            $obj_user->skill_ids  = implode(",", $post['skills']);
        }

        if(isset($post['functional_area']))
        {   
            $obj_user->functional_area_ids  = implode(",", $post['functional_area']);
        }
        
        $file_name = $this->upload_resume();
        
        if($file_name)
        {
            $obj_user->resume  = $file_name;
        }

        if($obj_user->save())
        {   
            $this->update_location();
            $this->update_career_history();
            $this->update_education_history();

            return response()->json(['status'=>'success','msg'=>'Profile updated successfully.']);
        }
        else
        {
            return response()->json(['status'=>'failed','type'=>'error','msg'=>SERVER_ERR_MSG]);
        }
    }

    public function update_profile_pic(Request $request)
    {
        if($request->hasFile('file')) 
        {
             $validator = Validator::make($request->all(), [
                      'file' => 'image|mimes:jpg,jpeg,gif,png|max:2048'
                  ]);

              if ($validator->fails())
              {
                   return response()->json(['is' => 'failed', 'error' => $validator->errors()->first()]);
              }

             $file  = $request->file('file');
             $image = time().'.'.$file->getClientOriginalExtension();

             $path = public_path().'/storage/specialist/profile_pic';
             $file->move($path, $image);

             $specialist = Specialist::find(auth()->user()->id);
             $specialist->image = $image;
             $save =  $specialist->save();
             if($save)
             {
                return response()->json(['status'=>'success','msg'=>'Profile pic updated successfully.']);
                
             }
        }   
    }
}
