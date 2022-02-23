<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employer_jobs, Job_application};

class PaymentHistoryController extends Controller
{
	protected $viewBasePath;
    protected $data;

	function __construct()
	{
		$this->employer_jobs = new Employer_jobs();
		$this->job_application = new Job_application();
		$this->viewBasePath = 'candidateApp.payment-history';
	}


	public function paymentHistory()
	{
		$this->data = [];
        $this->data['active_menue'] = 'referrals';
        $this->data['page'] = 'payment-history';
        $this->data['jobs'] = $this->employer_jobs->getCandidatePaymentHistory()->paginate(50);

    	if(request()->ajax())
        {  
            return view($this->viewBasePath.'.include.job_card', $this->data);
        }
    	return view($this->viewBasePath.'.main', $this->data);
	}

	public function paymentHistoryDetail($id)
	{
		$this->data = [];
        $this->data['active_menue'] = 'referrals';
        $this->data['page'] = 'payment-history';
        $this->data['job'] = $this->employer_jobs->getCandidatePaymentHistory($id)->first();
        $this->data['applications'] = $this->job_application->candidatePaymentHistory($id);

        if(!empty(request()->input('sortby')))
        {	$this->data["filter_data"] = $sort = request()->input('sortby');
    		if($sort == 'recency'){
    		 $this->data['applications'] = $this->data['applications']->orderBy('created_at','desc');	
    		}else if($sort == 'alphabetical'){
    		 $this->data['applications'] = $this->data['applications']->orderBy('name','asc');			
    		}
        }

        $this->data['applications'] = $this->data['applications']->paginate(2);

    	if(request()->ajax())
        {  
            return view($this->viewBasePath.'.include.application_card', $this->data);
        }

    	return view($this->viewBasePath.'.detail', $this->data);
	}

	public function scoreCard()
	{
		$this->data = [];
        $this->data['active_menue'] = 'referrals';
        $this->data['page'] = 'score-card';
        $this->data['jobs'] = $this->employer_jobs->getCandidatePaymentHistory()->paginate(1);
        $my_id = my_id();
        $this->data['total_referral'] = Job_application::where('refer_by', $my_id)->count();
        $this->data['success_referral'] = Job_application::where('refer_by', $my_id)->where('status', 'hired')->count();
        
        $this->data['referral_score'] = ($this->data['total_referral']!=0) ? ($this->data['success_referral'] / $this->data['total_referral'] * 100) : 0 ;

    	return view($this->viewBasePath.'.score-card', $this->data);
	}


}
