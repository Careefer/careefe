<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Specialist_jobs, Employer_jobs, Job_application};

class ReferralController extends Controller
{

	function __construct(){
		$this->baseView = 'specialistApp';
        $this->employer_jobs = new Employer_jobs();
        $this->job_application = new Job_application();
	}

    // main method
	public function index($type)
	{	$this->data = [];
		switch ($type)
    	{
    		case 'sent':
    			$this->data['jobs'] =  $this->referral_jobs('sent');
    			$this->data['page'] = 'sent';						
    			break;

			case 'received':
    			$this->data['jobs'] = $this->referral_jobs('receive');
    			$this->data['page'] = 'receive';
    			break;		    				
    	}

        $this->data['active_menue'] = 'referrals';

    	if($type !='sent' && $type !='received'){
    		return back()->with('error', 'Incorrect Url');		
    	}



        if(request()->ajax())
        {   if($type == 'sent')
            {
                return view($this->baseView.'.referral.include.referal-card', $this->data);

            }elseif($type == 'received'){
                return view($this->baseView.'.referral.include.referal-receive-card', $this->data);
            }
        }

		return view($this->baseView.'.referral.referal-sent', $this->data);
	}

	// referal job method
	public function referral_jobs($type)
	{
		$my_id = my_id();
		if($type == 'sent')
		{
        	$data = Specialist_jobs::orderBy('id','desc')
                    ->where(function($q) use($my_id){
                        $q->where('primary_specialist_id',$my_id)
                          ->orWhere('secondary_specialist_id',$my_id);
                    })
                    ->where(['status'=>'accept','is_current_specialist'=>'yes'])
                    ->whereHas('job.get_specialist_referral_sent_applications') 
                    ->paginate(1);

        	return $data;

		}elseif($type == 'receive')
		{
			$data = Specialist_jobs::orderBy('id','desc')
                    ->where(function($q) use($my_id){
                        $q->where('primary_specialist_id',$my_id)
                          ->orWhere('secondary_specialist_id',$my_id);
                    })
                    ->where(['status'=>'accept','is_current_specialist'=>'yes'])
                    ->whereHas('job.get_specialist_referral_receive_applications')
                    ->paginate(1);

        	return $data;
		}
	}

    public function referralSentDetail($id)
    {
       if($id)
       {
        $my_id = my_id();
        $this->data['job'] = $this->employer_jobs->where('id', $id)->first();
        $this->data['applications'] = $this->job_application->where('job_id', $id)->where('specialist_id', $my_id);
        $this->data['page'] = 'sent-detail';
        $this->data['active_menue'] = 'referrals';

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
            return view($this->baseView.'.referral-detail.include.application_card', $this->data);
        }

        $this->data['active_menue'] = 'referrals';

        //dd($this->data['applications']);
        //dd($this->data['job']->get_specialist_referral_sent_applications);
        return view($this->baseView.'.referral-detail.detail-page', $this->data);
       }else
       {
        return back()->with('error', 'Incorrect Url');  
       }
    }

    public function referralReceivetDetail($id)
    {
       if($id)
       {
        $my_id = my_id();
        $this->data['job'] = $this->employer_jobs->where('id', $id)->first();
        $this->data['applications'] = $this->job_application->where('job_id', $id)->where('specialist_id', $my_id)->where('status', 'hired');
        $this->data['page'] = 'receive-detail';
        $this->data['active_menue'] = 'referrals';

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
            return view($this->baseView.'.referral-detail.include.application_card', $this->data);
        }

        //dd($this->data['applications']);
        //dd($this->data['job']->get_specialist_referral_sent_applications);
        return view($this->baseView.'.referral-detail.detail-page', $this->data);
       }else
       {
        return back()->with('error', 'Incorrect Url');  
       }
    }

    public function updateRating(){
        if(request()->ajax())
        {
            $input = request()->all();
            $udata = $this->job_application::where('id', $input['application_id'])->update(['rating_by_specialist' =>  $input['rating']]);
            return json_encode(['success'=>true]);        
        }
    }

}
