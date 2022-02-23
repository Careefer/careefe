<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Specialist_jobs, Employer_jobs, Job_application};

class PaymentHistoryController extends Controller
{

	function __construct(){
		$this->baseView = 'specialistApp';
        $this->employer_jobs = new Employer_jobs();
        $this->job_application = new Job_application();
	}

    // main method
	public function index()
	{	//$this->data = [];		
		$this->data['jobs'] = $this->employer_jobs->getSpecilistAsReferrePaymentHistory()->paginate(1);
		$this->data['type'] = 'referral-payment';	    				
        $this->data['active_menue'] = 'payments';

        if(request()->ajax())
        {   
            return view($this->baseView.'.payment-history.include.job_card', $this->data);
        }
		return view($this->baseView.'.payment-history.main', $this->data);
	}

    // referal job method
    public function specialist_jobs_payment()
    {
        $my_id = my_id();
        $data = Specialist_jobs::orderBy('id','desc')
                    ->where(function($q) use($my_id){
                        $q->where('primary_specialist_id',$my_id)
                          ->orWhere('secondary_specialist_id',$my_id);
                    })
                    ->where(['status'=>'accept','is_current_specialist'=>'yes'])
                    ->whereHas('job.get_specialist_referral_receive_applications.specialistIsPayment', function($query){
                        $query->where('is_paid', 1);
                    })
                    ->paginate(1);
        return $data;
    }

    public function specialistPayment()
    {
        $this->data = [];       
        $this->data['jobs'] = $this->specialist_jobs_payment();
        $this->data['type'] = 'specialist-payment';                       
        $this->data['active_menue'] = 'payments';

        if(request()->ajax())
        {   
            return view($this->baseView.'.payment-history.include.job_card', $this->data);
        }
        return view($this->baseView.'.payment-history.main', $this->data);
    }


    public function specialistPaymentDetail($id)
    {
        if($id)
       {
        $my_id = my_id();
        $this->data['job'] = $this->employer_jobs->where('id', $id)->first();
        $this->data['applications'] = $this->job_application->specialistPaymentHistory($id);
        $this->data['type'] = 'specialist-payment';
        $this->data['active_menue'] = 'payments';

        if(!empty(request()->input('sortby')))
        {   $this->data["filter_data"] = $sort = request()->input('sortby');
            if($sort == 'recency'){
             $this->data['applications'] = $this->data['applications']->orderBy('created_at','desc');   
            }else if($sort == 'alphabetical'){
             $this->data['applications'] = $this->data['applications']->orderBy('name','asc');          
            }
        }
         $this->data['applications'] = $this->data['applications']->paginate(2);

        if(request()->ajax())
        {
            return view($this->baseView.'.payment-history.include.application_card', $this->data);
        }

        return view($this->baseView.'.payment-history.detail', $this->data);
       }else
       {
        return back()->with('error', 'Incorrect Url');  
       }
    }

    public function referralScore()
    {
        $this->data = [];       
        $this->data['jobs'] = $this->specialist_jobs_payment();
        $this->data['type'] = 'referral-score';                       
        $this->data['active_menue'] = 'payments';
        $my_id = my_id();
        $this->data['total_referral'] = Job_application::where('refer_by_specilist', $my_id)->count();
        $this->data['successful_referral'] = Job_application::where('refer_by_specilist', $my_id)->where('status', 'hired')->count();
        $this->data['referral_score'] = ($this->data['total_referral']!=0) ? ($this->data['successful_referral'] / $this->data['total_referral'] * 100) : 0 ;
        
        return view($this->baseView.'.payment-history.referral-scope', $this->data);
    }

    public function specialistScore()
    {
        $this->data = [];       
        $this->data['jobs'] = $this->specialist_jobs_payment();
        $this->data['type'] = 'specialist-score';                       
        $this->data['active_menue'] = 'payments';
        $my_id = my_id();
        $this->data['application_recommended'] = Job_application::where('specialist_id', $my_id)->count();
        $this->data['specialist_hired'] = Job_application::where('specialist_id', $my_id)->where('status', 'hired')->count();

        $this->data['specialist_score'] = ($this->data['application_recommended']!=0) ? ($this->data['specialist_hired'] / $this->data['application_recommended'] * 100) : 0 ;

        return view($this->baseView.'.payment-history.specialist-score', $this->data);
    }

    public function referralPaymentDetail($id)
    {
       if($id)
       {
        $my_id = my_id();
        $this->data['job'] = $this->employer_jobs->where('id', $id)->first();
        $this->data['applications'] = $this->job_application->referrePaymentHistory($id);
        $this->data['type'] = 'referal-payment';
        $this->data['active_menue'] = 'payments';

        if(!empty(request()->input('sortby')))
        {   $this->data["filter_data"] = $sort = request()->input('sortby');
            if($sort == 'recency'){
             $this->data['applications'] = $this->data['applications']->orderBy('created_at','desc');   
            }else if($sort == 'alphabetical'){
             $this->data['applications'] = $this->data['applications']->orderBy('name','asc');          
            }
        }
         $this->data['applications'] = $this->data['applications']->paginate(2);

        if(request()->ajax())
        {
            return view($this->baseView.'.payment-history.include.application_card', $this->data);
        }

        return view($this->baseView.'.payment-history.detail', $this->data);
       }else
       {
        return back()->with('error', 'Incorrect Url');  
       }
    }

}
