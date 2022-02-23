<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialist_jobs;
use App\Models\Job_application;
use App\Models\SpecialistAssignmentLog;
use App\Http\Controllers\SendNotificationController;
use App\Candidate;
use App\Jobs\DeclineJobBySpecialistJob;
use App\Admin;

class JobController extends Controller
{	
    protected $data;

    public function listing($type)
    {		
        $this->data['job_type'] = $type;
    	switch ($type)
    	{
    		case 'new':
    			$this->data['jobs'] =  $this->new_jobs();
    			break;

			case 'accepted':
    			$this->data['jobs'] = $this->accepted_jobs();
    			break;

    		case 'declined':
    			$this->data['jobs'] = $this->declined_jobs();
    			break;	    				
    	}

        if(request()->ajax())
        {
            return view('specialistApp.jobs.include.list_job_card_html',$this->data);
        }

        $this->data['active_menue'] = 'job';
    	return view('specialistApp.jobs.listing',$this->data);
    }

    // new jobs
    private function new_jobs()
    {		
    	$my_id = my_id();

    	$data = Specialist_jobs::orderBy('id','desc')
    				->where(function($q) use($my_id){
    					$q->where(function($query) use($my_id){
                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'pending');
                        })->orWhere(function($query) use ($my_id){
                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','pending');
                        });
    				})
    				->where(['is_current_specialist'=>'yes'])
    				->paginate(50);           

    	return $data;
    }

    // accepted jobs
    private function accepted_jobs()
    {		
    	$my_id = my_id();

        $data = Specialist_jobs::orderBy('id','desc')
                    ->where(function($q) use($my_id){
                        $q->where(function($query) use($my_id){
                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                        })->orWhere(function($query) use ($my_id){
                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                        });
                    })
                    ->where(['is_current_specialist'=>'yes'])
                    ->paginate(50);  

        return $data;
    }

    // declined jobs
    private function declined_jobs()
    {		
    	$my_id = my_id();

        $data = Specialist_jobs::orderBy('id','desc')
                    ->where(function($q) use($my_id){
                        $q->where(function($query) use($my_id){
                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'decline');
                        })->orWhere(function($query) use ($my_id){
                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','decline');
                        });
                    })
                    ->where(['is_current_specialist'=>'yes'])
                    ->paginate(50); 

        return $data;
    }

    /**
     * Decline job
     * @param string encrypt $job_id
     * @return void
     */
    public function make_job_decline($job_id)
    {
        $job_id = decrypt($job_id);
        $my_id = my_id();

        $obj_spc_job = Specialist_jobs::where('job_id',$job_id)
                        ->where('is_current_specialist', 'yes')
                        ->where(function($q) use($my_id)
                        {
                            $q->where(function($query) use($my_id){
                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'pending');
                            })->orWhere(function($query) use ($my_id){
                                $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','pending');
                            });
                        })
                        ->first();                                              

         if(!empty($obj_spc_job))
        {
            $data = [];
            $data['subject'] = 'Job Decline By Specialist';
            $data['job_id'] = @$obj_spc_job->job->job_id??''; 
            $data['specialist_type'] = '';
            $data['company'] = @$obj_spc_job->job->company->company_name??'';
            $data['position'] = @$obj_spc_job->job->position->name??'';

            if($obj_spc_job->primary_specialist_id == $my_id)
            {
                $obj_spc_job->primary_specialist_status = 'decline';
                $data['specialist_type'] = 'primary';
                $data['specialist_id'] = @$obj_spc_job->job->primary_specialist->specialist_id??'';
                $data['specialist_name'] = @$obj_spc_job->job->primary_specialist->name??'';

            }elseif($obj_spc_job->secondary_specialist_id == $my_id)
            {
                $obj_spc_job->secondary_specialist_status = 'decline';
                $data['specialist_type'] = 'secondary';
                $data['specialist_id'] = @$obj_spc_job->job->secondary_specialist->specialist_id??'';
                $data['specialist_name'] = @$obj_spc_job->job->secondary_specialist->name??'';
            }

            SpecialistAssignmentLog::where('job_id', $job_id)->where('specialist_id', $my_id)->where('is_current', 'yes')->update(['status'=>'decline']);

            $admin = Admin::where('id',1)->first(['id', 'email']);
            $email = $admin['email'];

            DeclineJobBySpecialistJob::dispatch($email, $data)->delay(now()->addMinutes(1));
        }               
        
        if($obj_spc_job->save())
        {
            request()->session()->flash('success_notify','Job declined successfully');
        }
        else
        {
            request()->session()->flash('error',SERVER_ERR_MSG);
        }

        return redirect()->back();
    }

    /**
     * Decline job
     * @param string encrypt $job_id
     * @return void
     */
    public function make_job_accept($job_id)
    {
        $job_id = decrypt($job_id);

        $my_id = my_id();

        $obj_spc_job = Specialist_jobs::where('job_id',$job_id)
                        ->where('is_current_specialist', 'yes')
                        ->where(function($q) use($my_id)
                        {
                            $q->where(function($query) use($my_id)
                            {
                                $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'pending');
                            })->orWhere(function($query) use ($my_id)
                            {
                                $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','pending');
                            });
                        })
                        ->first();                  

        if(!empty($obj_spc_job))
        {
            if($obj_spc_job->primary_specialist_id == $my_id)
            {   
                $obj_spc_job->primary_specialist_status = 'accept';
            }elseif($obj_spc_job->secondary_specialist_id == $my_id){
                $obj_spc_job->secondary_specialist_status = 'accept';
            }

            SpecialistAssignmentLog::where('job_id', $job_id)->where('specialist_id', $my_id)->where('is_current', 'yes')->update(['status'=>'accept']);
        }
        
        if($obj_spc_job->save())
        {
            (new SendNotificationController)->specialistAcceptJobNotification($job_id);
            
            request()->session()->flash('success_notify','Job accepted successfully');
        }
        else
        {
            request()->session()->flash('error',SERVER_ERR_MSG);
        }

        return redirect()->back();
    }
}
