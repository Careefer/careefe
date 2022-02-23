<?php

namespace App\Http\Controllers\CandidateApp;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserEducationHistory;
use App\Models\UserCareerHistory;
use App\Models\UserLocation;
use Illuminate\Http\Request;
use App\Models\TimeZones;
use App\Models\Currency;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Designation;
use App\Models\skill;
use App\Models\Education;
use App\Candidate;
use Validator;
use DB;


class ProfileController extends Controller
{
	public $data;

    public function profile_setting()
    {
    	$this->data['countries'] = Country::orderBy('name','asc')->where('status','active')->pluck('name','id');

        $this->data['profile_data'] = Candidate::findOrfail(auth()->user()->id);

        if(optional($this->data['profile_data']->current_location)->id)
        {   
            $c_id = $this->data['profile_data']->current_location->location_id;
            $this->data['c_location'] = Candidate::get_location_by_id($c_id);
        }

        if(optional($this->data['profile_data']->permanent_location)->id)
        {   
            $p_id = $this->data['profile_data']->permanent_location->location_id;
            $this->data['p_location'] = Candidate::get_location_by_id($p_id);
        }

        $this->data['designations'] = Designation::where('status','active')->pluck('name','id');
        $this->data['educations'] = Education::where('status','active')->pluck('name','id');

        $this->data['skills'] = skill::where('status','active')->pluck('name','id');

        $this->data['obj_state'] = new State;
        $this->data['obj_city'] = new City;

        $this->data['currencies'] = Currency::where(['status'=>'active'])->get();
        $this->data['timezones'] =  TimeZones::select('*', DB::raw('convert("offset", decimal) AS offset'))
                  ->orderBy('id', 'ASC')
                  ->get();
           
        return view('candidateApp.profile',$this->data);
    }

    private function update_location()
    {       
        $post = request()->all();

        $user_id = auth()->user()->id;

        //check if current location exist
        $objc = UserLocation::where(['user_id'=>$user_id,'user_type'=>'candidate','location_type'=>'current'])->first();
        
        if(!$objc)
        {
            $objc            = new UserLocation();
            $objc->user_id   = $user_id;
            $objc->user_type = 'candidate';
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
        $objP = UserLocation::where(['user_id'=>$user_id,'user_type'=>'candidate','location_type'=>'permanent'])->get()->first();
        if(!$objP)
        {
            $objP            = new UserLocation();
            $objP->user_id   = $user_id;
            $objP->user_type = 'candidate';
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
                    $addJobSkills = $post["job_skills_$key"];
                    $skillIds = [];
                    foreach ($addJobSkills as $addJobSkill) 
                    {
                        if(is_numeric($addJobSkill))
                        {
                             $skillIds[]  = $addJobSkill;
                        }
                        else
                        {
                            $slug = slug_url($addJobSkill);
                            $skill = new skill();
                            $skill->name = $addJobSkill;
                            $skill->slug = $slug;
                            $save = $skill->save();
                            if($save)
                            {
                                $skillIds[] = $skill->id;
                            }
                        }    
                    }
                    $job_skills_ids = implode(',', $skillIds);
                }  

                $arr = [];
                $arr['user_id']         = $user_id;
                $arr['user_type']       = 'candidate';
                $arr['company_name']    = $company_name; 

                if(isset($post['designation'][$key]))
                {
                    if(is_numeric($post['designation'][$key]))
                    {
                        $arr['designation_id']  = $post['designation'][$key];
                    }
                    else
                    {
                        $slug = slug_url($post['designation'][$key]);
                        $designation = new Designation();
                        $designation->name = $post['designation'][$key];
                        $designation->slug = $slug;
                        $save = $designation->save();
                        if($save)
                        {
                            $arr['designation_id'] = $designation->id;
                        }
                    }
                    //$arr['designation_id']  = $post['designation'][$key];
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
                    $arr['start_date']    = dateFormat($post['job_start_date'][$key]); 
                }

                $arr['end_date'] = null;
                if(isset($post['job_end_date'][$key]))
                {
                    $arr['end_date']    = dateFormat($post['job_end_date'][$key]); 
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
            DB::table('user_career_history')->where(['user_id'=>$user_id,'user_type'=>'candidate'])->delete();

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
                    $arr['user_type']       = 'candidate';
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
                        $arr['start_date']    = dateFormat($post['edu_start_date'][$edu_key]); 
                    }

                    $arr['end_date'] = null;
                    if($post['edu_end_date'][$edu_key])
                    {
                        $arr['end_date']    = dateFormat($post['edu_end_date'][$edu_key]); 
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
                db::table('user_education_history')->where(['user_id'=>$user_id,'user_type'=>'candidate'])->delete();
                // insert new fresh
                DB::table('user_education_history')->insert($insert_arr);
            }
        }
        catch(Exception $e)
        {

        }
    }


    private function validate_form()
    {
        $custom_error_msg = [];
        $post = request()->all(); 

        $rules = [
                        'name'           => 'required|max:100',
                        'phone'          => 'numeric|digits_between:8,15',
                        'resume'        => 'max:5120|mimes:doc,pdf,docx,zip', //5mb
                ];

        $custom_error_msg = [
                                'resume.max' => 'Size of file should not be more than 5MB.',
                                'resume.mimes'=>'The resume must be a file of type: doc, pdf, docx, zip.'
                            ];
        if(!empty($post['official_email']))
        {
            $rules['official_email'] = 'email|max:100';
        }
        $validator  = Validator::make($post,$rules,$custom_error_msg);


        if($validator->fails())
        {    
            return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);
        }

        for($i = 0; $i < count($post['job_start_date']); $i++)
        {
            $job_start_date=strtotime($post['job_start_date'][$i]);
            $job_end_date=strtotime($post['job_end_date'][$i]);

            if(!empty($post['job_end_date'][$i])){
                if($job_end_date < $job_start_date)
                {            
                     return response()->json(['status'=>'failed','type'=>'date-validation','msg'=>'End date must be greater than start date']);
                }
            }
           
        } 
    }


    public function update_profile(Request $request)
    {	
		try
        {
        	DB::beginTransaction();

            $currency = Currency::select('iso_code')->where('id',$request->currency)->first();
			
	    	$input = $request->all();
          
            $resp = $this->validate_form();
            if($resp)
            {
                return $resp;
            }
			
	        $candidate = Candidate::find(auth()->user()->id);
            if(!empty($input['email']))
            {
             $candidate->email              =   $input['email'];
            }
            $candidate->name                =   $input['name'];
            $candidate->official_email      =   $input['official_email'];
            $candidate->phone               =   $input['phone'];
	        $candidate->currency   	   		=  	$currency->iso_code;
	        $candidate->timezone       		=   $input['timezone'] ;
	        $candidate->profile_summary     =   $input['profile_summary'];
	        // if(isset($input['skills']))
	        // {   
	        //     $candidate->skill_ids  		= implode(",", $input['skills']);
	        // }

            if(isset($input['skills']))
             {
  
                    $addJobSkills = $input['skills'];
                    $skillIds = [];
                    foreach ($addJobSkills as $key => $addJobSkill) 
                    {
                        if(is_numeric($addJobSkill))
                        {
                             $skillIds[]  = $addJobSkill;
                        }
                        else
                        {
                            $slug = slug_url($addJobSkill);
                            $skill = new skill();
                            $skill->name = $addJobSkill;
                            $skill->slug = $slug;
                            $save = $skill->save();
                            if($save)
                            {
                                $skillIds[] = $skill->id;
                            }
                        }    
                    }
                    $candidate->skill_ids         = implode(',',$skillIds);
             }

	        $resume = $this->upload_resume();
	    	if($resume)
	    	{
	    	    $candidate->resume  = $resume;
	    	}

	    	$cover_letter = $this->upload_cover_letter();
	    	if($cover_letter)
	    	{
	    	    $candidate->cover_letter  = $cover_letter;
	    	}
	       
	        $save = $candidate->save(); 
            request()->session()->put('toIsoCode', $currency->iso_code);

	        if($save)
	        {  

        		$this->update_location();
                $this->update_career_history();
                $this->update_education_history();

	        	DB::commit();

        		request()->session()->flash('success','Profile updated successfully.');
                return response()->json(['status'=>'success','msg'=>'Profile updated successfully.']);

	        }
	        else
	        {
	        	return response()->json(['status'=>'failed','type'=>'error','msg'=>SERVER_ERR_MSG]);
	        }
	    
	    }
        catch(Exception $e)
        {
        	DB::rollback();
            return response()->json(['status'=>'failed','type'=>'error','msg'=>SERVER_ERR_MSG]);
        }  
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

             $path = public_path().'/storage/candidate/profile_pic';
             $file->move($path, $image);

             $candidate = Candidate::find(auth()->user()->id);
             $candidate->image = $image;
             $save =  $candidate->save();
             if($save)
             {
                return response()->json(['status'=>'success','msg'=>'Profile pic updated successfully.']);
                
             }
        }
        
        
    }

    // simple & drag upload resume
    public function upload_resume()
    {   
        $obj = request()->file('resume');

        $file_name = false;
        if($obj)
        {
            $file_extension = request()->file('resume')->getClientOriginalExtension();;
            $file_name = 'resume_'.'_'.time().'.'.$file_extension;

            $size = request()->file('resume')->getSize();
            $size = $size/(1024*1024); // in mb;

            if($size > 5) // 5 mb
            {
                echo json_encode(['status'=>'failed','type'=>'validation','msg'=>['resume'=>'File is to big max file size is 5mb']]); exit;
            }

            $resume_extensions = array("pdf", "doc", "docx");
            if(in_array($file_extension, $resume_extensions))
            {  
                $file = request()->file('resume');
                $path = public_path().'/storage/candidate/resume';
                $file->move($path, $file_name);

                if(request()->get('drag'))
                {
                    $my_detail  = my_detail();
                    $my_detail->resume = $file_name;    
                    $my_detail->save();
                }
            }
            else
            {   
                echo json_encode(['status'=>'failed','type'=>'validation','msg'=>['resume'=>'Please choose only .pdf,.doc,.docx type of files']]); exit;
            }
        }
        return $file_name;
    }

    //simple & drag upload cover letter
    public function upload_cover_letter()
    {   
        $obj = request()->file('cover_letter');


        $file_name = false;
        if($obj)
        {
            $file_extension = request()->file('cover_letter')->extension();
            $file_name = 'cover_letter_'.'_'.time().'.'.$file_extension;

            $size = request()->file('cover_letter')->getSize();
            $size = $size/(1024*1024); // in mb;

            if($size > 5) // 5 mb
            {
                echo json_encode(['status'=>'failed','type'=>'validation','msg'=>['cover_letter'=>'File is to big max file size is 5mb']]); exit;
            }

            $cover_letter_extensions = array("pdf", "doc", "docx");
            if(in_array($file_extension, $cover_letter_extensions))
            {
                $file = request()->file('cover_letter');
                $path = public_path().'/storage/candidate/cover_letter';
                $file->move($path, $file_name);

                if(request()->get('drag'))
                {   
                    $my_detail  = my_detail();
                    $my_detail->cover_letter = $file_name;    
                    $my_detail->save();
                }
            }
            else
            {   
                echo json_encode(['status'=>'failed','type'=>'validation','msg'=>['cover_letter'=>'Please choose only .pdf,.doc,.docx type of files']]); exit;
            }        
        }
        return $file_name;
    }

}
