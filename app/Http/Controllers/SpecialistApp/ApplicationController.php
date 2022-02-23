<?php

namespace App\Http\Controllers\SpecialistApp;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Specialist_jobs, Employer_jobs, Designation, WorldLocation, EmployerDetail, Job_application};
use App\Candidate;
use App\Specialist;

class ApplicationController extends Controller
{	
    protected $data;
    /*constructor*/
    public function __construct(){
        $this->employer_jobs = new Employer_jobs();
        $this->job_application = new Job_application();
        $this->candidate =  new Candidate();
    }

    /*application page*/
    public function listing($type)
    {		
        $filters = request()->all();
        $this->data['application_type'] = $type;

    	switch ($type)
    	{
    		case 'active':
    			$this->data['jobs'] =  $this->get_jobs("active");
    			break;

			case 'on-hold':
    			$this->data['jobs'] = $this->get_jobs("on_hold");
    			break;

    		case 'closed':
    			$this->data['jobs'] = $this->get_jobs("closed");
    			break;

           case 'cancelled':
                $this->data['jobs'] = $this->get_jobs("cancelled");
                break;        	    				
    	}
        
        /*filter By job Id*/
        if(isset($filters['job-id']) && !empty($filters['job-id']))
        { 
            $jobID = $filters['job-id'];
            $this->data['jobs'] =  $this->data['jobs']->whereHas('job', function( $query) use($jobID){
                        $query->where('job_id', '=', $jobID);
                    });
        }
        /*Position filter*/
        if(isset($filters['position']) && !empty($filters['position']))
        {
            $position = Designation::where('slug', $filters['position'])->select('id')->first();
            $this->data['jobs'] =  $this->data['jobs']->whereHas('job', function( $query) use($position){
                        $query->where('position_id', '=', $position->id);
                    });
        }

        /*Location filter*/
        if(isset($filters['location']) && !empty($filters['location']))
        {
            $job_loc_id     = $filters['location'];
            $obj_location   = WorldLocation::find($job_loc_id);
            $country_id     = $obj_location->country_id;
            $state_id       = $obj_location->state_id;
            $city_id        = $obj_location->city_id;

            $this->data['jobs'] =  $this->data['jobs']->whereHas('job', function( $query) use($country_id){
                        $query->where('country_id', '=', $country_id);
                    });
        }

        /*filter by company name*/
        if(isset($filters['company']) && !empty($filters['company']) && ($filters['company'] !='Company'))
        {
            $company_name = $filters['company'];
            $this->data['jobs'] =  $this->data['jobs']->whereHas('job', function( $query) use($company_name){
                        $query->whereHas('company', function($q) use($company_name){
                            $q->where('company_name', '=', $company_name);
                        });
                    });
        }    


        $this->data['jobs'] = $this->data['jobs']->paginate(50);

        $this->data['filter_job_ids'] = Employer_jobs::pluck('job_id','job_id'); 

        $this->data['filter_position_ids'] = Designation::where(['status'=>'active'])->pluck('name','slug');

        $this->data['filter_complany_ids'] = EmployerDetail::where(['status'=>'active'])->orderBy('company_name','asc')->pluck('company_name','company_name');

        $this->data['filter_data'] = $filters;
        $this->data['active_menue'] = 'applications';
        
        if(request()->ajax())
        {
            return view('specialistApp.applications.include.list_application_card_html', $this->data);
        }

    	return view('specialistApp.applications.listing', $this->data);
    }
    // new jobs
    private function get_jobs($status)
    {		
    	$my_id = my_id();
    	$data = Specialist_jobs::orderBy('id','desc')
    				->where(function($q) use($my_id){
    					// $q->where('primary_specialist_id',$my_id)
    					//   ->orWhere('secondary_specialist_id',$my_id);
                        $q->where(function($query) use($my_id){
                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                            })->orWhere(function($query) use ($my_id){
                                $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                            });
    				})
    				->where(['is_current_specialist'=>'yes'])
                    ->whereHas('job', function( $query) use($status){
                        $query->where('status', '=', $status);
                    })
                    ->groupBy('job_id');
    				//->paginate(3);    
    	return $data;
    }
    //application detail page
    public function applicationDetail($slug)
    {
      
        $filters = request()->all();
        $my_id = my_id();
        $jobs = $this->employer_jobs::where('slug', $slug)
                ->first();
      
        $my_detail = my_detail();      
        $applications = [];
        $candidates = [];

        $specialist_company_name = @$my_detail->current_company->company_name??NULL;

        /*check slug exists*/        
        if(@$jobs->id)
        {
            if($jobs->primary_specialist_id == $my_id)
            {
                 $applications = $this->job_application::where('job_id', $jobs->id); 
                 if(empty($specialist_company_name))
                 {
                    $applications = $applications->whereDoesntHave('candidate.current_company', function($query) use($specialist_company_name){
                        //company_name
                        $query->where('company_name', $specialist_company_name); 
                    });
                 }
            }elseif($jobs->secondary_specialist_id == $my_id)
            {
                $applications = $this->job_application::where('job_id', $jobs->id); 
                if(!empty($jobs->primary_specialist_id))
                {
                    $primary_specialist = Specialist::where('id', $jobs->primary_specialist_id)->first();
                     $specialist_company_name = @$primary_specialist->current_company->company_name??NULL;

                    if(empty($specialist_company_name))
                     {  
                        $applications = $this->job_application::where('job_id', $jobs->id); 
                        
                        $applications = $applications->whereHas('candidate.current_company', function($query) use($specialist_company_name){
                            //company_name
                            $query->where('company_name', $specialist_company_name); 
                        });

                     }
                }
            }
           
            $candidatesIds = $this->job_application::where('job_id', $jobs->id)->where('specialist_id', $my_id)->pluck('candidate_id');
            $candidates = $this->candidate::WhereIn('id', @$candidatesIds)->pluck('name', 'id');

            /*filter by application status*/
            if(isset($filters['application_status']) && !empty($filters['application_status'])){
                $applications = $applications->where('status', $filters['application_status']);
            }

            /*filter by candidate*/
            if(isset($filters['candidate']) && !empty($filters['candidate'])){
                $applications = $applications->where('candidate_id', $filters['candidate']);
            }


            /*filter by candidate*/
            if(isset($filters['location']) && !empty($filters['location'])){
                $job_loc_id     = $filters['location'];
                // $obj_location   = WorldLocation::find($job_loc_id);
                // $country_id     = $obj_location->country_id;
                // $state_id       = $obj_location->state_id;
                // $city_id        = $obj_location->city_id;

                $applications = $applications->whereHas('candidate.current_location', function($query) use($job_loc_id)
                        {
                            $query->where('location_id', $job_loc_id);
                        });
            }

            if(isset($filters['sortBy']) && !empty($filters['sortBy']))
            {
                if($filters['sortBy'] == 'recency')
                {
                     $applications = $applications->orderBy('created_at', 'asc');

                }elseif($filters['sortBy'] == 'alphabetical')
                {
                    $applications = $applications->orderBy('name', 'asc');

                }elseif($filters['sortBy'] == 'referree')
                {
                    $applications = $applications->orderBy('rating_by_referee', 'desc');

                }elseif($filters['sortBy'] == 'specialist')
                {
                    $applications = $applications->orderBy('rating_by_specialist', 'desc');
                }
            }

            $applications = $applications->with(['candidate.current_location'])->select('*', \DB::raw('(CASE 
                        WHEN status = "applied" THEN "Applied"
                        WHEN status = "in_progress_with_employer" THEN "In Progress with Employer"
                        WHEN status = "in_progress" THEN "In Progress with Specialist"
                        WHEN status = "success" THEN "Success"
                        WHEN status = "unsuccess" THEN "Unsuccess"
                        WHEN status = "hired" THEN "Hired"
                        WHEN status = "candidate_declined" THEN "Candidate declined"
                        WHEN status = "cancelled" THEN "Cancelled" 
                        END) AS status'))->paginate(50);
                      
        }else{
            return back()->with('error', 'Incorrect Url');
        }

        $this->data['applications'] = $applications;
        $this->data['jobs'] = $jobs;
        $this->data['candidates'] = $candidates;
        $this->data['filter_data'] = $filters;     

        //dd( $this->data );
        if(request()->ajax())
        {
            return view('specialistApp.applications.include.card_application_detail', $this->data);
        } 
        return view('specialistApp.applications.detail-page', $this->data);
    }
}
