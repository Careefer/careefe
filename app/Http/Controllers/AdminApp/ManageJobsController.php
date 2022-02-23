<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManageJobsFormRequest;
use App\Transformers\ManageJobsTransformer;
use App\Models\FunctionalArea;
use App\Models\Employer_jobs;
use App\Models\EmployerDetail;
use App\Models\Designation;
use App\Models\Education;
use App\Models\work_type;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\skill;
use App\Models\WorldLocation;
use App\Models\Employer_job_location;
use App\Models\Employer_job_location_cities;
use App\Models\Job_nature;
use App\Models\Specialist_jobs;
use App\Models\Job_application;
use App\Models\SpecialistAssignmentLog;
use App\Specialist;
use Validator;
use Exception;
use DB;
use App\Http\Controllers\SendNotificationController;

class ManageJobsController extends Controller
{
    
    protected $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-jobs';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = null)
    {   
        if(request()->ajax())
        {   
            $model = Employer_jobs::with(['company','position','work_type','jobSpecialist']);
            
            if($status)
            {  
                if($status == 'decline'){
                   $model = $model->whereHas('jobSpecialist', function($q){
                                $q->where(function($query){
                                    $query->where('primary_specialist_status', 'decline');
                                })->orWhere(function($query){
                                    $query->where('secondary_specialist_status','decline');
                                })->where('is_current_specialist', 'yes');
                            });
                }else{
                    $model->where(['status'=>$status]);
                }
            }

            if(request()->has('employer') && !empty(request('employer')))
            {   
                $model = $model->whereHas('company',function($qry){
                    $qry->where("company_name","like","%".request('employer')."%");

                });
            }

            if(request()->has('position') && !empty(request('position')))
            {   
                $model = $model->whereHas('position',function($qry){
                    $qry->where("name","like","%".request('position')."%");

                });
            }

            if(request()->has('specialist') && !empty(request('specialist')))
            {   
                $model = $model->whereHas('specialist',function($qry){
                    $qry->where("name","like","%".request('specialist')."%");
                });
            }


            return datatables()->eloquent($model)
                        ->filter(function($query)
                        {
                            if(request()->has('job_id') && !empty(request('job_id')))
                            {   
                                $query->where("job_id","like","%".request('job_id')."%");
                            }

                            if(request()->has('status') && !empty(request('status')) && $status != 'decline')
                            {   
                                $query->where("status","like","%".request('status')."%");
                            }

                            if(request()->has('date') && !empty(request()->get('date')))
                            {       
                                $date = get_date_db_format(request()->get('date'));
                                $query->where("created_at","like","%".$date."%");
                            }

                        })
                        ->setTransformer(new ManageJobsTransformer(new Employer_jobs))
                        ->toJson();
        }

        switch ($status)
        {
            case 'rejected':
                $this->data['active_sub_menue'] = 'rejected-jobs';
                break;

            case 'pending':
            $this->data['active_sub_menue'] = 'new-jobs';
            break;

            case 'decline':
            $this->data['active_sub_menue'] = 'declined-jobs';
            break;  
            
            default:
                $this->data['active_sub_menue'] = 'jobs';
                break;
        }

        return view('jobs.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['companies'] = EmployerDetail::orderBy('company_name')->pluck('company_name','id');

        $this->data['job_types'] = Job_nature::orderBy('id','desc')->pluck('title','id');

        $this->data['positions'] = Designation::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['countries'] = Country::orderBy('name','asc')->where('status','active')->pluck('name','id');

        $this->data['skills'] = skill::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['functional_area'] = FunctionalArea::orderBy('name')->where('status','active')->pluck('name','id');

        $this->data['educations'] = Education::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['work_types'] = work_type::where('status','active')->orderBy('name')->pluck('name','id');
        $this->data['job_id'] = Employer_jobs::get_next_job_id();

        $this->data['active_sub_menue'] = 'jobs';

        return view('jobs.create', $this->data);
    }

    private function manage_specialist_job($job_id)
    {
        $post = request()->all();

        $primary_specialist_id = $secondary_specialist_id = null;

        if(isset($post['primary_specialist'])) 
        {
            $primary_specialist_id = $post['primary_specialist'];
        }

        if(isset($post['secondary_specialist'])) 
        {
            $secondary_specialist_id = $post['secondary_specialist'];
        }

        $obj = Specialist_jobs::where(['job_id'=>$job_id,'is_current_specialist'=>'yes'])->first();

        if(!$obj)
        {   
            $obj_spc = new Specialist_jobs();
            $obj_spc->job_id = $job_id;
            $obj_spc->primary_specialist_id = $primary_specialist_id;
            $obj_spc->primary_specialist_status =  'pending';

            $specialist_log = new SpecialistAssignmentLog();
            $specialist_log->job_id = $job_id;
            $specialist_log->specialist_id = $primary_specialist_id;
            $specialist_log->user_type = 'primary';
            $specialist_log->status = 'pending';
            $specialist_log->is_current = 'yes';
            $specialist_log->save();
            

            if($secondary_specialist_id)
            {
                $obj_spc->secondary_specialist_id = $secondary_specialist_id;
                $obj_spc->secondary_specialist_status =  'pending';

                $specialist_log = new SpecialistAssignmentLog();
                $specialist_log->job_id = $job_id;
                $specialist_log->specialist_id = $secondary_specialist_id;
                $specialist_log->user_type = 'secondary';
                $specialist_log->status = 'pending';
                $specialist_log->is_current = 'yes';
                $specialist_log->save();
            }

            $obj_spc->is_current_specialist = 'yes';
            $obj_spc->save();
        }
        else
        {
            $obj_spc = Specialist_jobs::where(['job_id'=>$job_id,'primary_specialist_id'=>$primary_specialist_id,'secondary_specialist_id'=>$secondary_specialist_id,'is_current_specialist'=>'yes'])->first();
            
            if(!$obj_spc)
            { 
                $primary_specialist_status = 'pending';
                $secondary_specialist_status = 'pending';
                $obj_spc_old = Specialist_jobs::where(['job_id'=>$job_id,'is_current_specialist'=>'yes'])->first();
                //check status of old specialist in case of both same     
                if(!empty($obj_spc_old))
                {
                    if(@$obj_spc_old->primary_specialist_id == $primary_specialist_id)
                    {
                        $primary_specialist_status = $obj_spc_old->primary_specialist_status;
                    }

                    if(@$obj_spc_old->secondary_specialist_id == @$secondary_specialist_id)
                    {
                        $secondary_specialist_status = $obj_spc_old->secondary_specialist_status;
                    } 
                }

                // update previous not current 
                DB::table('specialist_jobs')
                    ->where(['job_id'=>$job_id])
                    ->update(['is_current_specialist'=>'no']);

                //update assignment log
                SpecialistAssignmentLog::where('job_id', $job_id)->update(['is_current'=>'no']);

                $obj_spc_n = new Specialist_jobs();
                $obj_spc_n->job_id = $job_id;
                $obj_spc_n->primary_specialist_id = $primary_specialist_id;
                $obj_spc_n->primary_specialist_status =  $primary_specialist_status;

                $specialist_log = new SpecialistAssignmentLog();
                $specialist_log->job_id = $job_id;
                $specialist_log->specialist_id = $primary_specialist_id;
                $specialist_log->user_type = 'primary';
                $specialist_log->status = $primary_specialist_status;
                $specialist_log->is_current = 'yes';
                $specialist_log->save();


                if($secondary_specialist_id)
                {
                    $obj_spc_n->secondary_specialist_id = $secondary_specialist_id;
                     $obj_spc_n->secondary_specialist_status =  $secondary_specialist_status;

                    $specialist_log = new SpecialistAssignmentLog();
                    $specialist_log->job_id = $job_id;
                    $specialist_log->specialist_id = $secondary_specialist_id;
                    $specialist_log->user_type = 'secondary';
                    $specialist_log->status = $secondary_specialist_status;
                    $specialist_log->is_current = 'yes';
                    $specialist_log->save();
                }

                $obj_spc_n->is_current_specialist = 'yes';
                $obj_spc_n->save();
            }
        }
    }

    private function validate_job_form()
    {   
        $custom_error_msg = [];
        $post = request()->all(); 
        $rules = [
                    'company_name'          => 'required',
                    'position'              => 'required|numeric|digits_between:1,10',
                    'add_job_country'       => 'required|numeric|digits_between:1,10',
                    'min_experience'        => 'required|numeric|digits_between:1,2|gt:0',
                    'max_experience'        => "required|numeric|digits_between:1,2|gte:".$post['min_experience'],
                    'vacancies'             =>'required|numeric|gt:0',
                    'min_salary'            =>'required|numeric|digits_between:1,7|gt:0',
                    'max_salary'            =>'required|numeric|digits_between:1,7|gte:'.$post['min_salary'],
                    'job_summary'           =>'required|max:500',
                    'job_description'       =>'required|max:500',
                    'work_type'             =>'required|numeric',
                    'commission_amt'        =>'required|numeric',
                    'referral_bonus_amt'    => 'required',
                    'specialist_bonus_amt'  => 'required',
                    'primary_specialist'    => 'required',
                    //'secondary_specialist'  => 'required',
                    'job_type'              => 'required',
                    'status'                => 'required'
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
            if(!isset($post["city_id"][$index]))
            {
                $rules["city_id[$index][]"] = "required";
                $custom_error_msg["city_id[$index][].required"] ="The city field is required";
            }

            if(!isset($post["state_id"][$index]) || empty($post["state_id"][$index]))
            {
                $rules["state_id[$index]"] = "required";
                $custom_error_msg["state_id[$index].required"] ="The state field is required";
            }
        }

        $validator  = Validator::make($post,$rules,$custom_error_msg);

        if($validator->fails())
        {    
            return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
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

            $insert_arr['job_id']               = Employer_jobs::get_next_job_id();
            $insert_arr['company_id']           = $post['company_name'];
            $insert_arr['position_id']          = $post['position'];
            $insert_arr['experience_min']       = $post['min_experience'];
            $insert_arr['experience_max']       = $post['max_experience'];
            $insert_arr['vacancy']              = $post['vacancies'];
            $insert_arr['skill_ids']            = implode(',',$post['add_job_skills']);
            $insert_arr['salary_min']           = $post['min_salary'];
            $insert_arr['salary_max']           = $post['max_salary'];
            $insert_arr['summary']              = $post['job_summary'];
            $insert_arr['description']          = $post['job_description'];
            $insert_arr['functional_area_ids']  = implode(',',$post['functional_area']);
            $insert_arr['education_ids']        = implode(',',$post['educations']);
            $insert_arr['work_type_id']         = $post['work_type'];
            $insert_arr['commission_type']      = $post['commission_type'];
            $insert_arr['commission_amt']       = $post['commission_amt'];
            $insert_arr['referral_bonus_amt']   = $post['referral_bonus_amt'];
            $insert_arr['specialist_bonus_amt'] = $post['specialist_bonus_amt'];
            $insert_arr['referral_bonus_percent']   = $post['referral_bonus_percent'];
            $insert_arr['specialist_bonus_percent'] = $post['specialist_bonus_percent'];

            $insert_arr['primary_specialist_id'] = null;
            $insert_arr['secondary_specialist_id'] = null;
            if(isset($post['primary_specialist']))
            {
                $insert_arr['primary_specialist_id'] = $post['primary_specialist'];
            }

            if(isset($post['secondary_specialist']))
            {
                $insert_arr['secondary_specialist_id'] = $post['secondary_specialist'];
            }

            $insert_arr['job_nature_id']        = $post['job_type'];
            $insert_arr['country_id']           = $post['add_job_country'];
            $insert_arr['status']               = $post['status'];

            $company_id = request()->get('company_name');
            $obj_company = EmployerDetail::find($company_id);

            $insert_arr['employer_id'] = @$obj_company->employees[0]->id;

            $insert_arr['industry_id'] = $obj_company->industry_id;
            $insert_arr['slug'] = $this->make_job_slug();

            $resp = Employer_jobs::create($insert_arr);

            $this->save_job_location($resp->id);

            if($resp->id)
            {   
                $this->manage_specialist_job($resp->id);
                request()->session()->flash('success_notify','Record added successfully.');

                $response = response()->json(['status'=>'success']);
            }
            else
            {
                 $response = response()->json(['status'=>'failed','type'=>'error','msg'=>'Job has not been added.']);
            }

            DB::commit();
            return $response;

        }
        catch(Exception $e)
        {
            DB::rollBack();
             return response()->json(['status'=>'failed','type'=>'error','msg'=>'Error something went wrong.']);

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
        $sql_satate = State::whereIn('id',$post['state_id'])->pluck('name')->take(2);        

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


    private function save_job_location($job_id)
    {
        $post = request()->all();

         $state_arr = $city_arr = [];
        // delete existing state
        Employer_job_location::where(['employer_job_id'=>$job_id])->delete();

        // delete existing cities
        Employer_job_location_cities::where(['employer_job_id'=>$job_id])->delete();

        foreach ($post['state_id'] as $key => $state_id)
        {   
            $state_arr[] = $state_id;
            $insert_arr = [];
            $insert_arr['employer_job_id']  = $job_id;
            $insert_arr['state_id']         = $state_id;

            $obj = Employer_job_location::create($insert_arr);
            
            if($obj->id)
            {
                $job_loc_id = $obj->id;

                if(isset($post['city_id'][$key]))
                {
                    foreach  ($post['city_id'][$key] as $city_id)
                    {  
                        $city_arr[]                    = $city_id; 
                        $arr                           = [];
                        $arr['employer_job_location_id'] = $job_loc_id;
                        $arr['employer_job_id']         = $job_id;
                        $arr['city_id']                 = $city_id;
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['obj_job'] = Employer_jobs::findorfail($id);
        $this->data['active_sub_menue'] = 'jobs';

        return view('jobs.show',$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        
        $job = Employer_jobs::findOrFail($id);

        $this->data['job']    = $job;

        $this->data['states'] = State::where(['country_id'=>$job->country_id,'status'=>'active'])->orderBy('name')->pluck('name','id');

        $this->data['obj_city'] = new City;

        $this->data['companies'] = EmployerDetail::orderBy('company_name')->pluck('company_name','id');

        $this->data['job_types'] = Job_nature::orderBy('id','desc')->pluck('title','id');

        $this->data['positions'] = Designation::where('status','active')->orderBy('name')->pluck('name','id');

        $this->data['countries'] = Country::orderBy('name','asc')->where('status','active')->pluck('name','id');

         $this->data['skills'] = skill::where('status','active')->orderBy('name')->pluck('name','id');

         $this->data['functional_area'] = FunctionalArea::orderBy('name')->where('status','active')->pluck('name','id');

         $this->data['educations'] = Education::where('status','active')->orderBy('name')->pluck('name','id');
         
          $this->data['work_types'] = Work_type::where('status','active')->orderBy('name')->pluck('name','id');
        $this->data['job_id'] = Employer_jobs::get_next_job_id();

         //$this->data['primary_specialists'] = Specialist::where(['id'=>$job->primary_specialist_id,'status'=>'active'])->orderBy('name')->pluck('name','id');

        $functional_area_ids = implode('|', explode(',', $job->functional_area_ids));

         $this->data['primary_specialists'] = Specialist::orderBy('name','asc')->whereRaw('CONCAT(",", functional_area_ids, ",") REGEXP ",('.$functional_area_ids.'),"')->pluck('name','id');

         $this->data['secondary_specialists'] = Specialist::orderBy('name','asc')->whereRaw('CONCAT(",", functional_area_ids, ",") REGEXP ",('.$functional_area_ids.'),"')->pluck('name','id'); 

         //$this->data['secondary_specialists'] = Specialist::where(['id'=>$job->secondary_specialist_id,'status'=>'active'])->orderBy('name')->pluck('name','id');

        $this->data['active_sub_menue'] = 'jobs';

        return view('jobs.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $resp = $this->validate_job_form();

        if($resp)
        {
            return $resp;
        }

        /*try
        {*/    
            DB::beginTransaction();

            $post = request()->all();

            $obj_this = new Employer_jobs();

            $edit_arr = [];

            $obj_job = Employer_jobs::find($id);
            $c_status = $obj_job->status;
            $this->manage_specialist_job($obj_job->id);


            if($post['status'] == 'cancelled')
            {
                $total_applicaton = $obj_job->getApplications(['hired','success'])->count();

                if($total_applicaton > 0)
                {
                    return response()->json(['status'=>'failed','type'=>'error','msg'=>'Unable to cancel job because job contain some success or hired applications.']);
                }
                Job_application::where('job_id', $id)->update(['status'=>'cancelled']);
            }

            $obj_job->company_id            = $post['company_name'];
            $obj_job->position_id           = $post['position'];
            $obj_job->experience_min        = $post['min_experience'];
            $obj_job->experience_max        = $post['max_experience'];
            $obj_job->vacancy               = $post['vacancies'];
            $obj_job->skill_ids             = implode(',',$post['add_job_skills']);
            $obj_job->salary_min            = $post['min_salary'];
            $obj_job->salary_max            = $post['max_salary'];
            $obj_job->summary               = $post['job_summary'];
            $obj_job->description           = $post['job_description'];
            $obj_job->functional_area_ids   = implode(',',$post['functional_area']);
            $obj_job->education_ids         = implode(',',$post['educations']);
            $obj_job->work_type_id          = $post['work_type'];
            $obj_job->commission_type       = $post['commission_type'];
            $obj_job->commission_amt        = $post['commission_amt'];
            $obj_job->referral_bonus_amt    = $post['referral_bonus_amt'];
            $obj_job->specialist_bonus_amt  = $post['specialist_bonus_amt'];
            $obj_job->referral_bonus_percent    = $post['referral_bonus_percent'];
            $obj_job->specialist_bonus_percent  = $post['specialist_bonus_percent'];

            if(isset($post['primary_specialist']))
            {
                $obj_job->primary_specialist_id = $post['primary_specialist'];
            }

            if(isset($post['secondary_specialist']))
            {
                $obj_job->secondary_specialist_id = $post['secondary_specialist'];
            }else{
                $obj_job->secondary_specialist_id = null;
            }


            $obj_job->job_nature_id         = $post['job_type'];
            $obj_job->country_id            = $post['add_job_country'];
            $obj_job->status                = $post['status'];

            $company_id = request()->get('company_name');
            $obj_company = EmployerDetail::find($company_id);
            $obj_job->industry_id = $obj_company->industry_id;
            $obj_job->slug = $this->make_job_slug();

                
            if($obj_job->save())
            {
                $employer_id = $obj_job->employer_id;
                $job_id = $obj_job->job_id;


                if($post['status'] != $c_status)
                {
                    // save job change log
                    save_job_status_log($id,$post['status'],'admin',auth()->guard('admin')->user()->id);
                }

                (new SendNotificationController)->adminpPublishJobNotification($employer_id,$job_id);

                if(!empty($post['primary_specialist']) || !empty($post['secondary_specialist']))
                {
                    $primary_specialist_id = $post['primary_specialist'];
                    $secondary_specialist_id = $post['secondary_specialist'];
                    (new SendNotificationController)->adminAssignJobNotification($primary_specialist_id,$secondary_specialist_id,$job_id);     
                }

                if(!empty($obj_job->primary_specialist_id) || !empty($obj_job->secondary_specialist_id))
                {
                    (new SendNotificationController)->adminAssignSpecialistNotification($employer_id,$job_id);  
                }

                $this->save_job_location($obj_job->id);
                $this->manage_specialist_job($obj_job->id);
                
                request()->session()->flash('success_notify','Record updated successfully.');

               DB::commit();

               $resp = response()->json(['status'=>'success']);
            }
            else
            {   
                $resp = response()->json(['status'=>'failed','type'=>'error','msg'=>'Job has not been updated']);
            }

            return $resp;
        /*}
        catch(Exception $e)
        {
            DB::rollBack();
            
            return response()->json(['status'=>'failed','type'=>'error','msg'=>'Error something went wrong.']);
        }*/
    }


    public function load_state($country_id)
    {
        $states = State::orderBy('name','asc')->where('country_id',$country_id)->get();

        $html = '';
        if($states->count())
        {   
            $html.='<option value=""></option>';

            foreach ($states as $key => $value)
            {
                $html.='<option value="'.$value->id.'">'.$value->name.'</option>';
            }
        }
        else
        {
            $html.='<option value="">No state found</option>';
        }

        echo $html;
    }

    public function load_city($state_id)
    {
        $cities = City::orderBy('name','asc')->where('state_id',$state_id)->get();

        $html = '';
        if($cities->count())
        {
            foreach ($cities as $key => $value)
            {
                $html.='<option value="'.$value->id.'">'.$value->name.'</option>';
            }
        }
        else
        {
            $html.='<option value="">No city found</option>';
        }

        echo $html;
    }


    public function load_specialist($functional_id)
    {
        $specialists = Specialist::orderBy('name','asc')->whereRaw("find_in_set($functional_id,functional_area_ids)")->get();

        $html = '';
        if($specialists->count())
        {   
            $html.='<option value=""></option>';
            foreach ($specialists as $key => $value)
            {
                $html.='<option value="'.$value->id.'">'.$value->name.'</option>';
            }
        }
        else
        {
            $html.='<option value="">No specialist found</option>';
        }

        echo $html;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $employer_job = Employer_jobs::findOrFail($id);
            $employer_job->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');

            return redirect()->route('jobs.job.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back();
        }
    }
}
