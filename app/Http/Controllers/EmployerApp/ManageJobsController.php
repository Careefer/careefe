<?php

namespace App\Http\Controllers\EmployerApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Country;
use App\Models\FunctionalArea;
use App\Models\Education;
use App\Models\work_type;
use App\Models\Employer_jobs;
use App\Models\Employer_job_location;
use App\Models\Employer_job_location_cities;
use App\Models\skill;
use App\Models\State;
use App\Models\City;
use App\Models\WorldLocation;
use App\Specialist;
use Validator;
use DB;


class ManageJobsController extends Controller
{	
	protected $data = [];

    public function listing()
    {	
        $filters = request()->all();

    	$my_id = auth()->user()->id;

        $obj_data = Employer_jobs::orderBy('id','desc');
        $obj_data->where(['employer_id'=>$my_id]);

        if(isset($filters['job-id']) && !empty($filters['job-id']))
        {
            $obj_data->where(['id'=>$filters['job-id']]);
        }

        if(isset($filters['position']) && !empty($filters['position']))
        {
            $obj_data->where(['position_id'=>$filters['position']]);
        }

        if(isset($filters['job_status']) && !empty($filters['job_status']))
        {
            $obj_data->where(['status'=>$filters['job_status']]);
        }

        if(isset($filters['specialist']) && !empty($filters['specialist']))
        {
            $id = $filters['specialist'];
            $obj_data->where(function($q) use ($id){
                      $q->where('primary_specialist_id',  $id)
                        ->orWhere('secondary_specialist_id',  $id);
                  });
        }

        if(isset($filters['location']) && !empty($filters['location']))
        {
            $job_loc_id     = $filters['location'];
            $obj_location   = WorldLocation::find($job_loc_id);
            $country_id     = $obj_location->country_id;
            $state_id       = $obj_location->state_id;
            $city_id        = $obj_location->city_id;

            //$obj_data->where('country_id', '=', $country_id);

            $obj_data->where(function($q) use ($country_id,$state_id,$city_id){
                      $q->WhereRaw('FIND_IN_SET("'.$city_id.'",city_ids)');
                        
                  });

           /* $obj_data->where(function($q) use ($country_id,$state_id,$city_id){
                      $q->where('country_id',  $country_id)
                        ->orWhereRaw('FIND_IN_SET("'.$state_id.'",state_ids)')
                        ->orWhereRaw('FIND_IN_SET("'.$city_id.'",city_ids)');
                  });*/
        }

        $this->data['jobs'] = $obj_data->paginate(50);
        
        $this->data['filter_job_ids'] = Employer_jobs::where(['deleted_at'=>null,'employer_id'=>$my_id])->pluck('job_id','id'); 

        $this->data['filter_position_ids'] = Designation::where(['status'=>'active'])->pluck('name','id');

        $this->data['filter_specialist'] = Specialist::where(['status'=>'active'])->orderBy('name')->pluck('name','id');

        $this->data['filter_data'] = $filters;



        if(request()->ajax())
        {
            return view('employerApp.jobs.card_job', $this->data);
        }

    	return view('employerApp.jobs.my_job_listing',$this->data);
    }

    public function view_add_job_form()
    {	
    	$this->data['positions'] = Designation::where('status','active')->orderBy('name')->pluck('name','id');

    	$this->data['countries'] = Country::orderBy('name','asc')->where('status','active')->pluck('name','id');

        $this->data['functional_area'] = FunctionalArea::orderBy('name')->where('status','active')->pluck('name','id');

        $this->data['educations'] = Education::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['work_types'] = work_type::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['skills'] = skill::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['job_id'] = Employer_jobs::get_next_job_id();
    	return view('employerApp.jobs.add',$this->data);
    }

    private function validate_job_form()
    {	
    	$custom_error_msg = [];
        $post = request()->all(); 

        $rules = [
                    'position'         	=> 'required',
                    'add_job_country'  	=> 'required|numeric|digits_between:1,10',
                    'min_experience' => 'required|numeric|lte:30',
                    'max_experience' => "required|numeric|lte:30|gte:".$post['min_experience'],
                    'vacancies' 	=>'required|numeric',
                    'min_salary' 	=>'required|numeric|digits_between:1,7|gt:0',
                    'max_salary' 	=>'required|numeric|digits_between:1,7|gte:'.$post['min_salary'],
                    'job_summary' =>'required|max:500',
                    'job_description' =>'required|max:500',
                    'work_type' =>'required|numeric',
                    'commission_amt' =>'required|numeric',
                ];

		 if($post['commission_type'] == 'percentage')
		 {
		 	$rules['commission_amt'] = 'required|numeric|max:100';
		 }

		 if(!isset($post['add_job_skills']))
         {	
         	$rules['add_job_skills[]'] = 'required';
            $custom_error_msg["add_job_skills[].required"] ="The skills field is required"; 
         }

         if(!isset($post['functional_area']))
         {	
         	$rules['functional_area[]'] = 'required';
            $custom_error_msg["functional_area[].required"] ="The functional area field is required"; 
         }

         if(!isset($post['educations']))
         {	
         	$rules['educations[]'] = 'required';
            $custom_error_msg["educations[].required"] ="The education field is required"; 
         }      

        foreach ($post['temp'] as $index => $val)
        {
        	if(!isset($post["add_job_city"][$index]))
        	{
	            $rules["add_job_city[$index][]"] = "required";
	            $custom_error_msg["add_job_city[$index][].required"] ="The city field is required";
        	}

        	if(!isset($post["add_job_state"][$index]) || empty($post["add_job_state"][$index]))
        	{
	        	$rules["add_job_state[$index]"] = "required";
		        $custom_error_msg["add_job_state[$index].required"] ="The state field is required";
        	}

        }

        $validator  = Validator::make($post,$rules,$custom_error_msg);


        if($validator->fails())
        {    
            return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);
        }
    }

    // make unique job slug
    private function make_job_slug()
    {   
        $post = request()->all();
        $str = 'job-';

        // job position
        $position_slug = Designation::where('id',$post['position'])->value('slug');
        
        if($position_slug)
        {
            $str .= $position_slug.'-';
        }

        // skill
        $sql_skill = Skill::whereIn('id',$post['add_job_skills'])->pluck('slug')->take(3);

        if($sql_skill->count())
        {
            $str .= implode('-',$sql_skill->toarray());
            $str .='-';
        }

        // add two state namespace
        $sql_satate = State::whereIn('id',$post['add_job_state'])->pluck('name')->take(2);        

        if($sql_satate->count())
        {
            $str .= implode('-',$sql_satate->toarray());
            $str .= '-';
        }

        // experience
        $str.=$post['min_experience'].'-to-';
        $str.=$post['max_experience'].'-year';

        $slug = slug_url($str);

        // check slug exist
        $exist = Employer_jobs::where('slug',$slug)->first();    
        if($exist) // exist
        {
            //find next upcoming job id
            $id = Employer_jobs::orderBy('id','desc')->value('id')+1;
            $slug .='-'.$id;
        }

        return $slug;
    }

    // create new job
    public function save_job()
    {	
    	$resp = $this->validate_job_form();

        if($resp)
        {
            return $resp;
        }

        try
        {
    		DB::beginTransaction();

    		$post = request()->all();

    		$obj_this = new Employer_jobs();

    		$insert_arr = [];

            if(is_numeric($post['position']))
            {
                $insert_arr['position_id']  = $post['position'];
            }
            else
            {
                $slug = slug_url($post['position']);
                $designation = new Designation();
                $designation->name = $post['position'];
                $designation->slug = $slug;
                $save = $designation->save();
                if($save)
                {
                    $insert_arr['position_id'] = $designation->id;
                }
            }

            $addJobSkills = $post['add_job_skills'];
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

            $educations = $post['educations'];
            $educationsIds = [];
            foreach ($educations as $key => $education) 
            {
                if(is_numeric($education))
                {
                     $educationsIds[]  = $education;
                }
                else
                {
                    $slug = slug_url($education);
                    $addEducation = new Education();
                    $addEducation->name = $education;
                    $addEducation->slug = $slug;
                    $save = $addEducation->save();
                    if($save)
                    {
                        $educationsIds[] = $addEducation->id;
                    }
                }    
            }

    		$insert_arr['job_id'] 			= Employer_jobs::get_next_job_id();
    		$insert_arr['employer_id'] 		= auth()->user()->id;
            $insert_arr['company_id']       = auth()->user()->company_id;

            if(isset(auth()->user()->company_detail->industry_id))
            {
                $insert_arr['industry_id']       = auth()->user()->company_detail->industry_id;
            }

    		$insert_arr['experience_min'] 	= $post['min_experience'];
    		$insert_arr['experience_max'] 	= $post['max_experience'];
    		$insert_arr['vacancy'] 			= $post['vacancies'];
    		$insert_arr['skill_ids'] 		= implode(',',$skillIds);
    		$insert_arr['salary_min'] 		= $post['min_salary'];
    		$insert_arr['salary_max'] 		= $post['max_salary'];
    		$insert_arr['summary'] 			= $post['job_summary'];
    		$insert_arr['description'] 		= $post['job_description'];
    		$insert_arr['functional_area_ids'] = implode(',',$post['functional_area']);
    		$insert_arr['education_ids'] 	= implode(',',$educationsIds);
    		$insert_arr['work_type_id'] 	= $post['work_type'];
    		$insert_arr['commission_type'] 	= $post['commission_type'];
    		$insert_arr['commission_amt'] 	= $post['commission_amt'];
    		$insert_arr['country_id'] 		= $post['add_job_country'];
            $insert_arr['status']           = 'pending';
    		$insert_arr['slug'] = $this->make_job_slug();

    		$resp = Employer_jobs::create($insert_arr);

    		$this->save_job_location($resp->id);

    		if($resp->id)
    		{	
                request()->session()->flash('success','Job added successfully');

                $response = response()->json(['status'=>'success','msg'=>'','redirect_url'=>route('employer.job.listing')]);
    		}
    		else
    		{
            	$response =  response()->json(['status'=>'failed','type'=>'error','msg'=>SERVER_ERR_MSG]);
    		}

    		DB::commit();

    		return $response;
        }
        catch(Exception $e)
        {
        	DB::rollBack();
            
            return response()->json(['status'=>'failed','type'=>'error',SERVER_ERR_MSG]);
        }
    }

    private function save_job_location($job_id)
    {
    	$post = request()->all();

        $state_arr = $city_arr = [];

		// delete existing state
		Employer_job_location::where(['employer_job_id'=>$job_id])->delete();

		// delete existing cities
		Employer_job_location_cities::where(['employer_job_id'=>$job_id])->delete();

		foreach ($post['add_job_state'] as $key => $state_id)
		{	
            $state_arr[] = $state_id;
		    $insert_arr = [];
		    $insert_arr['employer_job_id'] 	= $job_id;
		    $insert_arr['state_id'] 		= $state_id;

		    $obj = Employer_job_location::create($insert_arr);
	    	
		    if($obj->id)
		    {
	    		$job_loc_id = $obj->id;

		    	if(isset($post['add_job_city'][$key]))
		    	{
		    		foreach ($post['add_job_city'][$key] as $city_id)
		    		{	
                        $city_arr[]                     = $city_id;
		    			$arr                             = [];
		    			$arr['employer_job_location_id'] = $job_loc_id;
		    			$arr['employer_job_id'] 	     = $job_id;
		    			$arr['city_id']                  = $city_id;
		    			Employer_job_location_cities::create($arr);
		    		}	
		    	}
		    }
		}

        // update job's city and state ids

        $obj_job = Employer_jobs::find($job_id);
        $obj_job->state_ids = implode(',',$state_arr);
        $obj_job->city_ids = implode(',',$city_arr);
        $obj_job->save();
    }

    public function view_job($job_id)
    {
    	$this->data['obj_job'] = Employer_jobs::findorfail($job_id);

    	return view('employerApp.jobs.view',$this->data);
    }

    public function job_edit_form($job_id)
    {	
    	$this->data['positions'] = Designation::where('status','active')->orderBy('name')->pluck('name','id');

    	$this->data['countries'] = Country::orderBy('name','asc')->where('status','active')->pluck('name','id');

        $this->data['functional_area'] = FunctionalArea::orderBy('name')->where('status','active')->pluck('name','id');

        $this->data['educations'] = Education::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['work_types'] = Work_type::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['skills'] = skill::where('status','active')->orderBy('name')->pluck('name','id');

        $obj_job = Employer_jobs::findorfail($job_id);

        $this->data['states'] = State::where(['country_id'=>$obj_job->country_id,'status'=>'active'])->orderBy('name')->pluck('name','id');

        $this->data['obj_city']     = new City;
    	$this->data['obj_job']      = $obj_job;

    	return view('employerApp.jobs.edit',$this->data);
    }

    public function edit_job()
    {   
		$resp = $this->validate_job_form();

        if($resp)
        {
            return $resp;
        }

	    try
	    {    
        	DB::beginTransaction();

    		$post = request()->all();

    		$obj_this = new Employer_jobs();

    		$edit_arr = [];

    		$obj_job = Employer_jobs::find($post['edit_id']);
            $c_status = $obj_job->status;
            if($post['status'] == 'cancelled')
            {
                $total_applicaton = $obj_job->getApplications(['hired','success'])->count();

                if($total_applicaton > 0)
                {
                    return response()->json(['status'=>'failed','type'=>'error','msg'=>'Unable to cancel job because job contain some success or hired applications.']);
                }
            }

            if(is_numeric($post['position']))
            {
                $obj_job->position_id  = $post['position'];
            }
            else
            {
                $slug = slug_url($post['position']);
                $designation = new designation();
                $designation->name = $post['position'];
                $designation->slug = $slug;
                $save = $designation->save();
                if($save)
                {
                    $obj_job->position_id  = $designation->id;
                }
            }

            $addJobSkills = $post['add_job_skills'];
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

            $educations = $post['educations'];
            $educationsIds = [];
            foreach ($educations as $key => $education) 
            {
                if(is_numeric($education))
                {
                     $educationsIds[]  = $education;
                }
                else
                {
                    $slug = slug_url($education);
                    $addEducation = new Education();
                    $addEducation->name = $education;
                    $addEducation->slug = $slug;
                    $save = $addEducation->save();
                    if($save)
                    {
                        $educationsIds[] = $addEducation->id;
                    }
                }    
            }

    		$obj_job->employer_id 		= auth()->user()->id;
    		$obj_job->experience_min 	= $post['min_experience'];
    		$obj_job->experience_max 	= $post['max_experience'];
    		$obj_job->vacancy 			= $post['vacancies'];
    		$obj_job->skill_ids 		= implode(',',$skillIds);
    		$obj_job->salary_min 		= $post['min_salary'];
    		$obj_job->salary_max 		= $post['max_salary'];
    		$obj_job->summary 			= $post['job_summary'];
    		$obj_job->description 		= $post['job_description'];
    		$obj_job->functional_area_ids = implode(',',$post['functional_area']);
    		$obj_job->education_ids 	= implode(',',$educationsIds);
    		$obj_job->work_type_id 	= $post['work_type'];
    		$obj_job->commission_type 	= $post['commission_type'];
    		$obj_job->commission_amt 	= $post['commission_amt'];
    		$obj_job->country_id 		= $post['add_job_country'];

            if($post['status'])
            {
    		  $obj_job->status 			= $post['status'];
            }

    		if($obj_job->save())
    		{
                if($post['status'] != $c_status)
                {
                    // save job change log
                    save_job_status_log($post['edit_id'],$post['status'],'employer',auth()->guard('employer')->user()->id);
                }

    			$this->save_job_location($obj_job->id);
    			
    			request()->session()->flash('success','Job updated successfully');

                $response = response()->json(['status'=>'success','msg'=>'','redirect_url'=>route('employer.job.view',[$obj_job->id])]);
    		}
    		else
    		{	
            	$response =  response()->json(['status'=>'failed','type'=>'error','msg'=>SERVER_ERR_MSG]);
    		}

    		DB::commit();

    		return $response;
        }
        catch(Exception $e)
        {
        	DB::rollBack();
            
            return response()->json(['status'=>'failed','type'=>'error',SERVER_ERR_MSG]);
        }
    }
}
