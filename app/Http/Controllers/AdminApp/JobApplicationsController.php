<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Transformers\JobApplicationTransformer;
use App\Models\{Job_application, PaymentHistory, ChangeStatusLog};
use App\Models\WorldLocation;


class JobApplicationsController extends Controller
{	
    private $data = [];

    public function __construct(){
        $this->job_application = new Job_application();
        $this->paymentHistory =  new PaymentHistory();
    }

	// applicatoin listing
    public function listing()
    {	
    	if(request()->ajax())
        {       
            //$model = Job_application::with(['job.position','job.company','job.primary_specialist']);

            $model = Job_application::select('job_applications.*')->has('job.company')
                    ->with(['job.position','job.company','job.primary_specialist'])->select('*', \DB::raw('(CASE 
                        WHEN status = "applied" THEN "Applied"
                        WHEN status = "in_progress_with_employer" THEN "In Progress with Employer"
                        WHEN status = "in_progress" THEN "In Progress with Specialist"
                        WHEN status = "success" THEN "Success"
                        WHEN status = "unsuccess" THEN "Unsuccess"
                        WHEN status = "hired" THEN "Hired"
                        WHEN status = "candidate_declined" THEN "Candidate declined"
                        WHEN status = "cancelled" THEN "Cancelled" 
                        END) AS status'));
            
            // company name filter
            if(request()->has('company_name') && !empty(request()->get('company_name')))
            {
                $model = $model->whereHas('job',function($query){
                    $query->whereHas('company',function($q)
                    {
                        $q->where("company_name","like","%".request()->get('company_name')."%");
                    });
                });
            }

            // position filter
            if(request()->has('position') && !empty(request()->get('position')))
            {
                $model = $model->whereHas('job',function($query){
                    $query->whereHas('position',function($q)
                    {
                        $q->where("name","like","%".request()->get('position')."%");
                    });
                });
            }

            // filter job id
            if(request()->has('job_id') && !empty(request()->get('job_id')))
            {
                $model = $model->whereHas('job',function($query){
                    $query->where("job_id","like","%".request()->get('job_id')."%");
                });
            }

            // filter application location
            if(request()->has('application_location') && !empty(request()->get('application_location')))
            {  
                $model = $model->whereHas('candidate',function($q1)
                {
                    $q1->whereHas('current_location',function($q2)
                    {
                        $q2->whereHas('world_location',function($q4)
                        {
                            $q4->where("location","like","%".request()->get('application_location')."%");
                        });
                    });
                });
            }

            // filter job location 
            if(request()->has('job_location') && !empty(request()->get('job_location')))
            {   
                $location_id = request()->get('job_location');

                $obj_loc = WorldLocation::select('country_id','state_id','city_id')->where(['id'=>$location_id,'status'=>'active'])->orderBy('id','desc')->first();

                $model = $model->whereHas('job',function($query) use($obj_loc) {

                    if($obj_loc->city_id)
                    {   
                        $city_id = $obj_loc->city_id;

                        $query->whereRaw('FIND_IN_SET(?,city_ids)',$city_id);
                    }
                    else if($obj_loc->state_id)
                    {   
                        $state_id = $obj_loc->state_id;
                        $query->whereRaw('FIND_IN_SET(?,state_ids)',$state_id);
                    }
                    else
                    {
                        $query->where('country_id',$obj_loc->country_id);
                    }
                });
            }


            //filter assigned specialist
            if(request()->has('assigned_specialist') && !empty(request()->get('assigned_specialist')))
            {   
                $model = $model->whereHas('job',function($query){
                    $query->whereHas('primary_specialist',function($q)
                    {
                        $q->where("name","like","%".request()->get('assigned_specialist')."%");
                    });
                });
            }    

            $obj = Datatables::eloquent($model)
                    ->filter(function($query){

                        // application id filter
                        if(request()->has('application_id') && !empty(request()->get('application_id')))
                        {   
                            $query->where("application_id","like","%".request()->get('application_id')."%");
                        }

                        if(request()->has('applicant_name') && !empty(request()->get('applicant_name')))
                        {   
                            $query->where("name","like","%".request()->get('applicant_name')."%");
                        }

                        if(request()->has('date') && !empty(request()->get('date')))
                        {       
                            $date = get_date_db_format(request()->get('date'));
                            $query->where("created_at","like","%".$date."%");
                        }

                        // status filter
                        if(request()->has('status') && !empty(request()->get('status')))
                        {   
                            $query->where("status","like","%".request()->get('status')."%");
                        }



                    })->setTransformer(new JobApplicationTransformer(new Job_application))
                        ->toJson();
                    
            return $obj;
        }
        $this->data['active_menue']= 'manage-applications';
    	return view('jobs.applications.listing',$this->data);
    }

    //view job application
    public function view($id)
    {   
        $this->data['obj_application'] = $application = Job_application::where('id',$id)->firstOrFail();

        if(empty($application))
         {
            return back()->with('error', 'application not found');
         }

         
         if($application->status == 'applied')
         {
            $application_status = ['applied' => 'Applied', 'in_progress' =>'In Progress with specialist'];
         }elseif($application->status == 'in_progress'){
            $application_status = ['in_progress'=> 'In Progress with specialist', 'in_progress_with_employer' =>'In Progress with employer'];
         }elseif($application->status == 'in_progress_with_employer'){
            $application_status = ['in_progress_with_employer' =>'In Progress with employer', 'success' =>'Success', 'unsuccess' =>'Unsuccess'];
         }elseif($application->status == 'success'){
            $application_status = ['success' =>'Success', 'hired'=>'Hired'];
         }elseif($application->status == 'unsuccess')
         {
            $application_status = ['unsuccess' =>'Unsuccess'];
         }elseif($application->status == 'hired'){
            $application_status = ['hired' =>'Hired'];
         }  

         $this->data['application_status'] = $application_status;      

        return view('jobs.applications.view',$this->data);
    }

    public function updateJobStatus($id, Request $request){
        if($id)
        {
            try
            {   
                \DB::beginTransaction();
                $input = $request->all();
                if($input['status'])
                {       
                    if($input['status'] == 'in_progress_with_employer')
                    {  
                        $application =  Job_application::where('id', $id)->first();
                         if($application->job)
                         {
                           $specialist_id  = (@$application->job->primary_specialist) ? @$application->job->primary_specialist->id : (@$application->job->secondary_specialist ? @$application->job->secondary_specialist->id : '');
                          
                           if($specialist_id){
                                Job_application::where('id', $id)->update(['status'=>$input['status'], 'specialist_id'=>$specialist_id]);
                           }else{
                            return back()->with('error', 'Please assign  specialist to this job first.');
                           } 
                         }

                    }elseif($input['status'] == 'hired' && isset($input['salary']))
                    {
                            
                        $application =  Job_application::where('id', $id)->first();

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
                        //refer by specialist as candidate      
                        }elseif($application->refer_by_specilist){
                            //get referee commision 
                            $rData = $this->job_application->refereeCommissionCalculate($application, $input['salary'], 'specialist');

                            $user_type = 'referre-specialist';

                            $this->paymentHistory::savePaymentTransaction($application, $rData, $user_type);
                        }

                        Job_application::where('id', $id)->update(['status'=> $input['status'], 'salary'=> $input['salary']]);
                    }
                    else
                    {
                        Job_application::where('id', $id)->update(['status'=> $input['status']]);
                    }

                    $my_id = auth()->user()->id;
                    ChangeStatusLog::create(['user_type'=> 'admin', 'user_id'=> $my_id, 'status'=> $input['status'], 'application_id'=>$id]);

                    \DB::commit();

                    return back()->with('success','Successfully updated status');
                }
                return back()->with('error', 'Please choose correct status');
            }catch(\Exception $e){

                \DB::rollBack();
                dd($e);
            }    
        }else{
            return back()->with('error', 'application not found');
        }
    } 
}
