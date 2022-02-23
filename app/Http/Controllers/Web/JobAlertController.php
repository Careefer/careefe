<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FunctionalArea;
use App\Models\WorldLocation;
use App\Models\work_type;
use App\Models\City;
use App\Models\Designation;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Industry;
use App\Models\EmployerDetail;
use App\Models\Job_alert;
use App\Models\Employer_jobs;

class JobAlertController extends Controller
{   
    // job listing page
    public function create(Request $req)
    {
    	$req->validate([
    			'email' => 'required|email|max:50'
    		]);

    	$param  = $req->all();
    	$email 	= $req->get('email');

    	$insert_arr = ['email'=>$email,'ip'=>$req->ip()];

		if(auth()->guard('candidate')->check())
		{
			$insert_arr['candidate_id'] = auth()->guard('candidate')->user()->id;
		}

    	// keyword
    	if(isset($param['k']) && !empty($param['k']))
    	{
    		$insert_arr['keyword'] = $param['k'];
    	}

    	// functional area
    	if(isset($param['f']) && !empty($param['f']))
    	{
        	$insert_arr['functional_area_ids'] = FunctionalArea::select('id')->where(['slug'=>$param['f'],'status'=>'active'])->orderBy('id','desc')->value('id');
    	}

        //dd($insert_arr);

    	// location search
        if(isset($param['l']) && !empty($param['l']))  
        {
            $obj_loc = WorldLocation::select('country_id','state_id','city_id')->where(['slug'=>$param['l'],'status'=>'active'])->orderBy('id','desc')->first();

            $insert_arr['country_id'] = $obj_loc->country_id;
            
            if($obj_loc->city_id)
            {   
                $insert_arr['city_ids'] = $obj_loc->city_id;
            }

            if($obj_loc->state_id)
            {   
                $insert_arr['state_ids'] = $obj_loc->state_id;
            }      
        }

        // location/cities
        if(isset($param['c']) && !empty($param['c']))
        {
            $sql_city = City::whereIn('slug',$param['c'])->where(['status'=>'active'])->pluck('id');

            if($sql_city->count())
            {	
            	$city_arr = $sql_city->toarray();

            	if(isset($obj_loc->city_id))
            	{
            		$city_arr[] = $obj_loc->city_id; 
            	}
                $insert_arr['city_ids'] = implode(',',$city_arr);
            }
        }

        // work type
    	if(isset($param['w-t']) && !empty($param['w-t']))
        {
        	$sql_w = work_type::whereIn('slug',$param['w-t'])->pluck('id');

            if($sql_w->count())
            {
                $insert_arr['work_type_ids'] = implode(',',$sql_w->toarray());
            }
        }

        // referral bonous
        if(isset($param['rb']) && !empty($param['rb']))
        {
            $rb_arr     = explode('-',$param['rb']);
            $insert_arr['referral_bonus_from']   = isset($rb_arr[0])?$rb_arr[0]:0;     
            $insert_arr['referral_bonus_to']     = isset($rb_arr[1])?$rb_arr[1]:0;
        }

        // salary
        if(isset($param['sal']) && !empty($param['sal']))
        {
            $sal_arr     = explode('-',$param['sal']);
            $insert_arr['salary_from']   = isset($sal_arr[0])?$sal_arr[0]:0;     
            $insert_arr['salary_to']     = isset($sal_arr[1])?$sal_arr[1]:0;
        }

        // Designation
        if(isset($param['dg']) && !empty($param['dg']))
        {
            $sql_dg = Designation::whereIn('slug',$param['dg'])->pluck('id');

            if($sql_dg->count())
            {
                $insert_arr['position_ids'] = implode(',',$sql_dg->toarray());
            }
        }

        // Experience
        if(isset($param['exp']) && !empty($param['exp']))
        {
            $exp_arr    = explode('-',$param['exp']);
            $insert_arr['experience_from'] = isset($exp_arr[0])?$exp_arr[0]:0;     
            $insert_arr['experience_to']   = isset($exp_arr[1])?$exp_arr[1]:0; 
        }

        // skills
        if(isset($param['sk']) && !empty($param['sk']))
        {
            $sql_skill = Skill::whereIn('slug',$param['sk'])->pluck('id');

            if($sql_skill->count())
            {
                $insert_arr['skill_ids'] = implode(',',$sql_skill->toarray());
            }
        }

        // education
        if(isset($param['edu']) && !empty($param['edu']))
        {
            $sql_edu = Education::whereIn('slug',$param['edu'])->pluck('id');

            if($sql_edu->count())
            {
                $edu_ids    = $sql_edu->toarray();
                $insert_arr['education_ids']    = implode(',', $edu_ids); 
            }
        }

        // industry
        if(isset($param['ind']) && !empty($param['ind']))
        {
            $sql_ind = Industry::whereIn('slug',$param['ind'])->pluck('id');

            if($sql_ind->count())
            {
                $ind_ids = $sql_ind->toarray();

                $insert_arr['industry_ids'] = implode(',',$ind_ids);
            }
        }

        // company 
        if(isset($param['emp']) && !empty($param['emp']))
        {
            $sql_comp = EmployerDetail::whereIn('slug',$param['emp'])->pluck('id');

            if($sql_comp->count())
            {
                $company_ids = $sql_comp->toarray();
                $insert_arr['company_ids'] = implode(',', $company_ids);
            }
        }

        $data = Job_alert::where($insert_arr)->orderBy('id','desc')->get()->first();

        if(!$data) // should not exist
        {
        	$obj  = Job_alert::create($insert_arr);
        }
        else
        {
        	$data->updated_at = GMT_DATE_TIME;
        	$data->save();
        }

        return back()->with('success','You have successfully subscribed to the job alerts');
    }

    // job detail page
    public function create_job_alert($slug)
    {
        request()->validate([
            'email' => 'required|email'
        ]);

        $email  = request()->get('email');

        $insert_arr = ['email'=>$email,'ip'=>request()->ip()];

        if(auth()->guard('candidate')->check())
        {
            $insert_arr['candidate_id'] = auth()->guard('candidate')->user()->id;
        }

        $obj_job = Employer_jobs::where(['slug'=>$slug,'status'=>'active'])->firstOrFail();

        if($obj_job)
        {
            // functional area
            if($obj_job->functional_area_ids)
            {
                $insert_arr['functional_area_ids'] = $obj_job->functional_area_ids;
            }

            // country id
            if($obj_job->country_id)
            {
                $insert_arr['country_id'] = $obj_job->country_id;
            }

            // state ids
            if($obj_job->state_ids)
            {
                $insert_arr['state_ids'] = $obj_job->state_ids;
            }

            // city ids
            if($obj_job->city_ids)
            {
                $insert_arr['city_ids'] = $obj_job->city_ids;
            }

            // city ids
            if($obj_job->work_type_id)
            {
                $insert_arr['work_type_ids'] = $obj_job->work_type_id;
            }

            // referral bonus
            if($obj_job->referral_bonus_amt)
            {
                $insert_arr['referral_bonus_from'] = 0;
                $insert_arr['referral_bonus_to'] = $obj_job->referral_bonus_amt;
            }

            // salary from 
            if($obj_job->salary_min)
            {
                $insert_arr['salary_from'] = $obj_job->salary_min;
            }

            // salary to 
            if($obj_job->salary_max)
            {
                $insert_arr['salary_to'] = $obj_job->salary_max;
            }

            // position/designation  
            if($obj_job->position_id)
            {
                $insert_arr['position_ids'] = $obj_job->position_id;
            }

            // position/designation  
            if($obj_job->position_id)
            {
                $insert_arr['position_ids'] = $obj_job->position_id;
            }

            //experience min
            if($obj_job->experience_min)
            {
                $insert_arr['experience_from'] = $obj_job->experience_min;
            }

            //experience max
            if($obj_job->experience_max)
            {
                $insert_arr['experience_to'] = $obj_job->experience_max;
            }

            //skill
            if($obj_job->skill_ids)
            {
                $insert_arr['skill_ids'] = $obj_job->skill_ids;
            }

            //education
            if($obj_job->education_ids)
            {
                $insert_arr['education_ids'] = $obj_job->education_ids;
            }

            //education
            if($obj_job->industry_id)
            {
                $insert_arr['industry_ids'] = $obj_job->industry_id;
            }

            //company
            if($obj_job->company_id)
            {
                $insert_arr['company_ids'] = $obj_job->company_id;
            }

            $data = Job_alert::where($insert_arr)->orderBy('id','desc')->get()->first();

            if(!$data) // should not exist
            {
                $obj  = Job_alert::create($insert_arr);
            }
            else
            {
                $data->updated_at = GMT_DATE_TIME;
                $data->save();
            }
        }

        return back()->with('success','You have successfully subscribed to the job alerts');
    }
}
