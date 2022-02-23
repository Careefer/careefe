<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employer_jobs, Job_application, ChangeStatusLog, PaymentHistory};
use App\Http\Controllers\SendNotificationController;

class JobDetailController extends Controller
{	
	protected $data;
	/*constructor*/
    public function __construct()
    {
    	$this->employer_jobs = new Employer_jobs();
    	$this->job_application = new Job_application();
        $this->paymentHistory =  new PaymentHistory();
    }

    public function viewJobDetail($application_id)
    {
         $application = $this->job_application::where('application_id', $application_id)->first();
         $application_status = [];

         if(empty($application))
         {
         	return back()->with('error', 'Job not found');
         }

         if($application->status == 'applied')
         {
            $this->job_application::where('application_id', $application_id)->update(['status'=>'in_progress']);
            $application->status = 'in_progress';
            $application_status = ['in_progress' =>'In Progress with specialist'];
         }elseif($application->status == 'in_progress'){
            $application_status = ['in_progress'=> 'In Progress with specialist'];
         }elseif($application->status == 'in_progress_with_employer'){
            $application_status = ['in_progress_with_employer' =>'In Progress with employer'];
         }elseif($application->status == 'success'){
            //$application_status = ['success' =>'Success', 'hired'=>'Hired'];
            $application_status = ['success' =>'Success'];
         }elseif($application->status == 'unsuccess')
         {
            $application_status = ['unsuccess' =>'Unsuccess'];
         }elseif($application->status == 'hired'){
            $application_status = ['hired' =>'Hired'];
         }           

     $this->data['application'] = $application;
     $this->data['application_status'] = $application_status;            	
     return view('specialistApp.application-detail.detail-page',  $this->data);
    }

    public function updateSpecialistNotes($id)
    {
    	try{   
            \DB::beginTransaction();
            $input = request()->all();
    		$application = $this->job_application::find($id);
            //create payment transactions 
            if(isset($input['salary']) && request()->status == 'hired')
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

            // update application note and status
            $application->specialist_notes = request()->specialist_notes;
            $application->specialist_personal_notes = request()->specialist_personal_notes;
    		$application->recommended_by =  auth()->user()->id;
            
            if(request()->status == 'in_progress'){
                $application->status = 'in_progress_with_employer';
            }else{
                 $application->status = request()->status;
            }

    		$application->rating_by_specialist = request()->rating_by_specialist;
    		if(request()->recommended_by)
    		{
    			$application->recommended_by = auth()->user()->id;
                $application->specialist_id = auth()->user()->id;
    		}

            if(isset($input['salary'])){
                $application->salary =  $input['salary'];               
            }

    		$application->update();
            //send notification     
            $candidate_id = $application->candidate_id;
            $specialist_id = $application->specialist_id;
            $application_id = $application->application_id;
            $job_id = $application->job_id;

            if(request()->status == 'in_progress'){
                 $application_status = 'In Progress with employer';
            }else{
                 $application_status = request()->status;
            }
            $my_id = my_id();
            //insert in log 
            ChangeStatusLog::create(['user_type'=> 'specialist', 'user_id'=> $my_id, 'status'=> request()->status, 'application_id'=>$id]);
           
            (new SendNotificationController)->jobStatusNotification($candidate_id,$application_status,$specialist_id,$application_id,$job_id);

            \DB::commit();
    		return back()->with('success', 'Special Notes updated.');
    	}catch(\Exception $e){
            \DB::rollBack();
    		dd($e);
    	}
    }

    public function shareWithEmployer($app_id)
    {
        $application_id = decrypt($app_id);
        $my_id = my_id();

        $dta = $this->job_application::where('id', $application_id)->update(['specialist_id'=>$my_id]); 
        
        if($dta)
        {
            request()->session()->flash('success_notify','Application  share with employer successfully');
        }
        else
        {
            request()->session()->flash('error',SERVER_ERR_MSG);
        }
        return redirect()->back();   
    }
}
