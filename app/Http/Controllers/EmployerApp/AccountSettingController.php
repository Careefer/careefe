<?php

namespace App\Http\Controllers\EmployerApp;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Employer;
use App\Models\TimeZones;
use App\Models\EmployerDetail;
use App\Models\Industry;
use App\Models\WorldLocation;
use App\Models\Employer_branch_office;
use Validator;



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
        $this->data['active_tab'] = 'company';
        if(session('req_type') == 'change_password')
        {
            $this->data['active_tab'] = 'change_password';
        }

        $obj = auth()->user();

        $this->data['user_info'] = $obj;

        $obj_company = $obj->company_detail;

        $this->data['company_detail'] = $obj_company;
        
        $this->data['other_location'] = 'Not specified';

        if($obj_company->branch_locations())
        {
            $this->data['other_location'] = implode(";",$obj_company->branch_locations()->toarray());
        }

        $this->data['timezone'] = null;
        
        if($obj->timezone)
        {
            $this->data['timezone'] = $obj->timezone->name."(".$obj->timezone->text.")";
        }

        return view('employerApp.account_setting',$this->data);
    }

    /**
     * Show the application's account change password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        session()->flash('req_type','change_password');  
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

    public function view()
    {   
        $obj = auth()->user();

        $this->data['user_info'] = $obj;

        $obj_company = $obj->company_detail;

        $this->data['company_detail'] = $obj_company;
        
        $this->data['other_location'] = 'Not specified';

        if($obj_company->branch_locations())
        {
            $this->data['other_location'] = implode(";",$obj_company->branch_locations()->toarray());
        }

        $this->data['timezone'] = null;
        
        if($obj->timezone)
        {
            $this->data['timezone'] = $obj->timezone->name."(".$obj->timezone->text.")";
        }

        return view('employerApp.profile.profile_view',$this->data);
    }

    public function  profile_edit()
    {      
        $this->data['active_tab'] = 'company';
        
        if(session('req_type') == 'personal')
        {
            $this->data['active_tab'] = 'personal';
        }

        $this->data['industries'] = Industry::orderBy('name')->where('status','active')->pluck('name','id');

        $this->data['time_zones'] = TimeZones::orderBy('name')->selectRaw("CONCAT(name,'(',text,')') AS name,id")->get();

        $company_id = auth()->user()->company_id;

        $this->data['obj_company']  = EmployerDetail::find($company_id);
        $this->data['my_location'] = auth()->user()->my_location;

        return view('employerApp.profile.profile_edit',$this->data);
    }

    private function validate_company_profile_data()
    {   
            $post               = request()->all();
            $custom_error_msg   = [];

            $rules = [
                        'head_office' => 'required',
                        'website_url' => 'nullable|url'
                     ];

            foreach (request()->get('temp') as $key => $value)
            {
                $rules["location_id_$key"] = "required";
                $custom_error_msg["location_id_$key.required"] ="The other location field is required"; 
            }

            $validator  = Validator::make($post,$rules,$custom_error_msg);

            if($validator->fails())
            {    
                return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);
            }  
    }

    /**
     * udate branches
     */
    private function update_branches($company_id)
    {
        $post = request()->all();

        foreach ($post as $input_name => $location_id)
        {   
            if(strpos($input_name, "location_id_") === 0)
            {
                $country_id = WorldLocation::select('country_id')->where(['id'=>$location_id,'status'=>'active'])->orderBy('id','desc')->value('country_id');
                $insert_arr[] = ['employer_id'=>$company_id,'location_id'=>$location_id,'country_id'=>$country_id];
            }
        }

        // delete existing
        Employer_branch_office::where(['employer_id'=>$company_id])->delete(); 

        Employer_branch_office::insert($insert_arr); 
    }


    public function update_company_profile()
    {   

        try
        {   
            $post = request()->all();

            $resp = $this->validate_company_profile_data();
        
            if($resp)
            {
                return $resp;
            }

            $company_id = auth()->user()->company_id;

            $obj_company = EmployerDetail::find($company_id);
            $obj_company->head_office_location_id   = $post['head_office'];
            $obj_company->size_of_company = $post['size_of_company'];
            $obj_company->website_url = $post['website_url'];
            $obj_company->industry_id = $post['industry'];
            $obj_company->about_company = $post['about_company'];

            if($obj_company->save())
            {   
                $this->update_branches($company_id);
                return response()->json(['status'=>'success','msg'=>'Profile updated successfully.']);
            }
            else
            {
                return response()->json(['status'=>'failed','type'=>'error','msg'=>'Unexpected error occurred while trying to process your request.!!']);
            }
        }
        catch(Exception $e)
        {
            return response()->json(['status'=>'failed','type'=>'error','msg'=>'Unexpected error occurred while trying to process your request.!!']);
        }

        return redirect()->back()->withInput(request()->input()); 
    }

    public function update_profile_pic(Request $request)
    {
        if($request->hasFile('file')) 
        {
             $validator = Validator::make($request->all(), [
                      'file' => 'mimes:jpg,jpeg,gif,png|max:2048'
                  ]);

              if ($validator->fails())
              {
                   return response()->json(['is' => 'failed', 'error' => $validator->errors()->first()]);
              }

             $file  = $request->file('file');
             $image = time().'.'.$file->getClientOriginalExtension();

             $path = public_path().'/storage/employer/company_logo';
             $file->move($path, $image);

             $company_id = auth()->user()->company_id;
             $obj_company = EmployerDetail::find($company_id);
             $obj_company->logo = $image;
             $save =  $obj_company->save();
             if($save)
             {
                return response()->json(['status'=>'success','msg'=>'Logo updated successfully.']);
                
             }
        }
        
        
    }

    public function update_profile()
    {    
        session()->flash('req_type','personal');   
        try
        {
            $id = auth()->user()->id;
            request()->validate([
                                'name'  => 'required',
                                'email'             => "required|unique:employers,email,{$id},id,deleted_at,NULL",
                                'mobile'             => "required|digits_between:8,15|unique:employers,mobile,{$id},id,deleted_at,NULL",
                            ]);

            $post = request()->all();

            $obj = auth()->user();
            $obj->name          = $post['name'];
            $obj->email         = $post['email'];
            $obj->mobile        = $post['mobile'];
            $obj->time_zone_id  = $post['timezone'];
            $obj->location_id   = $post['personal_location_id'];
            
            if($obj->save())
            {   
                request()->session()->flash('success','Profile updated successfully.');
            }
        }
        catch(Exception $e)
        {
            request()->session()->flash('error','Error something went wrong');
        }

        return redirect()->back(); 
    }
}
