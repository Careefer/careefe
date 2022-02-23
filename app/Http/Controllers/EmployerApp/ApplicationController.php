<?php

namespace App\Http\Controllers\EmployerApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel; 
use App\Exports\ApplicationDetailExport;
use App\{Candidate, Specialist};
use App\Models\{Specialist_jobs, Employer_jobs, Designation, WorldLocation, EmployerDetail, Job_application, PaymentHistory, ReferralPaymentHistoryLog, ChangeStatusLog};
use App\Http\Controllers\SendNotificationController;

class ApplicationController extends Controller
{
    protected $data;
    /*constructor*/
    public function __construct(){
    	$this->viewBasePath = 'employerApp.applications';
        $this->employer_jobs = new Employer_jobs();
        $this->job_application = new Job_application();
        $this->candidate =  new Candidate();
        $this->paymentHistory  = new PaymentHistory();
        $this->referralPaymentHistoryLog = new ReferralPaymentHistoryLog();
    }
    /* job card listing page page*/
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
            $this->data['jobs'] =  $this->data['jobs']->where('job_id', $jobID);
        }
        /*Position filter*/
        if(isset($filters['position']) && !empty($filters['position']))
        {
            $position = $filters['position'];
            $this->data['jobs'] =  $this->data['jobs']->whereHas('position', function($query) use ($position){
                 $query->where('slug', '=', $position);
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

            $this->data['jobs'] =  $this->data['jobs']->where('country_id', '=', $country_id);
        }

        /*filter by company name*/
        if(isset($filters['specialist']) && !empty($filters['specialist']))
        {
            $specialist = $filters['specialist'];
            $this->data['jobs'] =  $this->data['jobs']->whereHas('primary_specialist', function($query) use($specialist){
                $query->where('specialist_id', $specialist);
            })
            ->orwhereHas('secondary_specialist', function($query) use($specialist){
                $query->where('specialist_id', $specialist);
            });
    		// ->where(function($q) use($specialist_id){
    		// 	$q->where('primary_specialist_id',$specialist_id)
    		// 			->orWhere('secondary_specialist_id',$specialist_id);
    		// 	});
        }    


        $this->data['jobs'] = $this->data['jobs']->paginate(50);

        $this->data['filter_job_ids'] = Employer_jobs::pluck('job_id','job_id'); 

        $this->data['filter_position_ids'] = Designation::where(['status'=>'active'])->pluck('name','slug');

        $this->data['filter_specialist_ids'] = Specialist::where(['status'=>'active'])->orderBy('name','asc')->pluck('name','specialist_id');

        $this->data['filter_data'] = $filters;
        $this->data['active_menue'] = 'applications';

        if(request()->ajax())
        {
        	return view($this->viewBasePath.'.include.list_application_card_html', $this->data);
        }      
        
    	return view($this->viewBasePath.'.listing', $this->data);
    }
    // new jobs
    private function get_jobs($status)
    {
    	$my_id = my_id();
    	$data = $this->employer_jobs::where('status', '=', $status)
    			->where('employer_id', $my_id)
    			->orderBy('id','desc');
    				// ->where(['status'=>'pending','is_current_specialist'=>'yes'])
    				//->paginate(3);    
    	return $data;
    }
    //application listing page
    public function applicationDetail($slug)
    {
        $filters = request()->all();

        $jobs = $this->employer_jobs::where('slug', $slug)->first();
        
        $applications = [];
        $candidates = [];
        /*check slug exists*/        
        if(@$jobs->id)
        {
            $applications = $this->job_application::where('job_id', $jobs->id)->where('specialist_id','!=', NULL)->whereNotIn('status', ['in_progress', 'applied']);
            $candidatesIds = $this->job_application::where('job_id', $jobs->id)->pluck('candidate_id');
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

                }elseif($filters['sortBy'] == 'employer')
                {
                    $applications = $applications->orderBy('rating_by_employer', 'desc');

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

        if(request()->ajax())
        {
            return view($this->viewBasePath.'.include.card_application_detail', $this->data);
        } 
        return view($this->viewBasePath.'.detail-page', $this->data);
    }
    // application detail page 
    public function viewJobDetail($application_id)
    {
     $application = $this->job_application::where('application_id', $application_id)->first();
     if(empty($application))
     {
        return back()->with('error', 'application not found');
     }

     if($application->status == 'in_progress_with_employer')
     {
        $application_status = ['in_progress_with_employer' =>'In Progress with employer', 'success' =>'Success', 'unsuccess' =>'Unsuccess'];
     }elseif($application->status == 'success')
     {
        $application_status = ['success' =>'Success', 'hired'=>'Hired'];
     }elseif($application->status == 'unsuccess')
     {
        $application_status = ['unsuccess' =>'Unsuccess'];
     }elseif($application->status == 'hired')
     {
        $application_status = ['hired' =>'Hired'];
     }            

     $this->data['application'] = $application;
     $this->data['application_status'] = @$application_status;             
     return view($this->viewBasePath.'.application-detail-page',  $this->data);
    }
    //update employer note
    public function updateEmployerNotes($id, Request $request)
    {
     try
     {
            \DB::beginTransaction();
            $input = $request->all();
            $application = $this->job_application::find($id);

            if(isset($input['salary']))
            {   
                //get specialiat commission
                $sData = $this->job_application->specialistCommissionCalculate($application, $input['salary']);
                $user_type = 'specialist';
                //save data for specialist commission
                $this->paymentHistory::savePaymentTransaction($application, $sData, $user_type);
            
               //get careefer commission record 
                $cData = $this->job_application->careeferCommissionCalculate($application, $input['salary']);
                $user_type = 'admin';
                //save data for admin commission
                $this->paymentHistory::savePaymentTransaction($application, $cData, $user_type);
        

                //refer by candidate 
                if($application->refer_by)
                {   //get referee commision 
                    $rData = $this->job_application->refereeCommissionCalculate($application, $input['salary'], 'candidate');
                    
                    $user_type = 'candidate';
                    //save data for admin referee
                    $this->paymentHistory::savePaymentTransaction($application, $rData, $user_type);
                //refer by specialist      
                }elseif($application->refer_by_specilist){
                    //get referee commision 
                    $rData = $this->job_application->refereeCommissionCalculate($application, $input['salary'], 'specialist');

                    $user_type = 'referre-specialist';

                    $this->paymentHistory::savePaymentTransaction($application, $rData, $user_type);
                }
            }

            $application = $this->job_application::find($id);
            if(isset($input['salary'])){
                $application->salary =  $input['salary'];               
            }
            $application->employer_notes = request()->employer_notes;
            $application->status = request()->status;
            $application->rating_by_employer = request()->rating_by_employer;
            $application->update();

            $my_id = my_id();
            ChangeStatusLog::create(['user_type'=> 'employer', 'user_id'=> $my_id, 'status'=> request()->status, 'application_id'=>$id]);

            $candidate_id = $application->candidate_id;
            $specialist_id = $application->specialist_id;
            $application_id = $application->application_id;
            $application_status = request()->status;
            (new SendNotificationController)->jobStatusNotificationByEmployer($candidate_id,$specialist_id,$application_id,$application_status);

            \DB::commit();
            return back()->with('success', 'Employer Information updated.');
        
        }catch(\Exception $e)
        {   \DB::rollBack();
            dd($e);
        }
    }
    // export application data
    public function exportApplicationDetail($id)
    {
        $dta = $this->job_application::find($id);
        return Excel::download(new ApplicationDetailExport($id), @$dta->application_id.'_'.@$dta->name.'_Data.csv');
    }

    // private function savePaymentTransaction($application, $dta, $user_type){
    //     $pdata = new PaymentHistory();
    //     $pdata->application_id = $dta['application_id'];
    //     $pdata->job_id = $dta['job_id'];
    //     $pdata->user_type = $user_type;

    //     if($user_type == 'candidate' || $user_type == 'referre-specialist')
    //     {   
    //         if($user_type == 'candidate')
    //         {
    //             $pdata->user_id = $application->refer_by;

    //         }elseif($user_type == 'referre-specialist')
    //         {
    //             $pdata->user_id = $application->specialist_id;
    //         }
            
    //         $pdata->commission = $dta['referee_commision_percentage'];
    //         $pdata->commission_max_amount = $dta['referee_commission_max'];
        
    //         if(!empty($dta['job_fill_final_data']))
    //         {
    //             $pdata->total_referred = $dta['job_fill_final_data']['total_referred'];
    //             $pdata->sum_of_penalty_x_referred = $dta['job_fill_final_data']['sum_of_penalty_x_referred'];
    //             $pdata->weighted_average_penalty = $dta['job_fill_final_data']['weighted_average_penalty'];
    //             $pdata->bouns_rate = $dta['job_fill_final_data']['bouns_rate'];
    //         }
    //     }

    //     if($user_type == 'specialist'){
    //         $pdata->user_id = (@$application->job->primary_specialist_id)??@$application->job->secondary_specialist_id;
    //         $pdata->commission = $dta['specialist_commision_percentage'];
    //         $pdata->commission_max_amount = $dta['specialist_commission_max'];
    //     }

    //     if($user_type != 'admin'){
    //       $pdata->amount =  ($dta['application_weight_amount'] + $dta['job_fill_weight_amount']);
    //       $pdata->application_weight = $dta['application_weight'];
    //       $pdata->job_fill_weight = $dta['job_fill_weight']; 
    //       $pdata->application_weight_amount = $dta['application_weight_amount'];
    //       $pdata->job_fill_weight_amount =  $dta['job_fill_weight_amount'];
    //     }else{
    //         $pdata->amount = $dta['careefer_commission_amount'];
    //         $pdata->commission = $dta['careefer_commission'];
    //         $pdata->user_id = 1; 
    //     }
        
    //     $pdata->employer_id = $application->job->employer_id;
    //     $pdata->careefer_commission_type  = $dta['careefer_commission_type'];
    //     $pdata->careefer_commission_amount = $dta['careefer_commission_amount'];
    //     $pdata->is_paid = 0;

    //     $pdata->save();

    //     if($user_type == 'candidate' || $user_type == 'referre-specialist')
    //     {
    //         if(!empty($dta['history'])){
    //             $history = $dta['history'];
    //             foreach ($history as $key => $value) {
    //                 $value['payment_history_id'] = $pdata['id'];
    //                 $this->referralPaymentHistoryLog::create($value);
    //             }
    //         }
    //     }

    //     return $pdata;
    // }    
}
