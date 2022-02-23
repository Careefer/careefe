<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Bank_format, Country, Bank_format_countries, CandidateBankDetail, Bank_format_field, Employer_jobs, Job_application};

class ReferralController extends Controller
{
    //
	protected $viewBasePath;
    protected $data;

	function __construct(){
		$this->bankFormatCountry = new Bank_format_countries();
		$this->candidateBankDetail =  new CandidateBankDetail();
		$this->bankFormatField = new Bank_format_field();
		$this->employer_jobs = new Employer_jobs();
		$this->job_application = new Job_application();
		$this->viewBasePath = 'candidateApp.referral';
		$this->viewBase = 'candidateApp';
	}

	public function referral($type)
	{
		$this->data = [];
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
                return view($this->viewBasePath.'.sent', $this->data);

            }elseif($type == 'received'){
                return view($this->viewBasePath.'.receive', $this->data);
            }
        }

    	return view($this->viewBasePath.'.referral-list', $this->data);
	}

	// referal job method
	public function referral_jobs($type)
	{
		$my_id = my_id();
		if($type == 'sent')
		{
	        $data = $this->employer_jobs::whereHas('candidate_referral_sent_applications')->paginate(50);
	        return $data;

		}elseif($type == 'receive')
		{
			$data = $this->employer_jobs::whereHas('candidate_referral_receive_applications')->paginate(50);
	        return $data;
		}
	}

	public function bankDetail()
	{
		$my_id = my_id();

		if(request()->input('country_id') && request()->input('country_id') !== '')
		{
			$bankformat= $this->bankFormatCountry->getbankFormat(request()->input('country_id'));
			$this->data['bank_format_fields'] = (@$bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
			$this->data['countryId'] = request()->input('country_id');
		}else
		{
			$dataField = $this->candidateBankDetail::where('candidate_id', $my_id)->first(['country_id']);

			if(!empty($dataField)){
				$bankformat= $this->bankFormatCountry->getbankFormat($dataField['country_id']);
				$this->data['bank_format_fields'] = (@$bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
				$this->data['countryId'] = $dataField['country_id'];	
			}else{
				$bankformat= $this->bankFormatCountry->getbankFormat(1);
				$this->data['bank_format_fields'] = (@$bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
				$this->data['countryId'] = 1;	
			}
		}
		$this->data['page'] = 'bank-detail';
		$this->data['countries'] 	= Country::pluck('name','id');
		return view($this->viewBasePath.'.bank-detail.bank-detail', $this->data);
	}

	public function updateBankDetail()
	{
		$inputData = request()->all();
		$my_id = my_id();
		$bankformat = $this->bankFormatCountry->getbankFormat($inputData['country_id']);
		$bankformatdata = ($bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
		$this->candidateBankDetail->where('candidate_id', $my_id)->delete();
		if(count($bankformatdata) > 0 ) 
		{
			foreach ($bankformatdata as $key => $value)
			{
				if(array_key_exists($value->name, $inputData)){
					$data['bank_format_id'] = $value->bank_format_id;
					$data['bank_format_field_id'] = $value->id;
					$data['name'] = $value->name;
					$data['label'] = $value->label;
					$data['value'] = $inputData[$value->name];
					$data['candidate_id'] = $my_id;
					$data['country_id'] = $inputData['country_id'];
					$this->candidateBankDetail::create($data);
				}
			}
		}
		return back()->withInput()->with('success', 'Bank Detail Updated Successfully');
	}

	public function referralSentDetail($id)
	{
		if($id)
        {
	        $my_id = my_id();
	        $this->data['job'] = $this->employer_jobs->where('id', $id)->first();
	        $this->data['applications'] = $this->job_application->where('job_id', $id)->where('refer_by', $my_id);
	        $this->data['page'] = 'sent-detail';
	        $this->data['active_menue'] = 'referrals';


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
	            return view($this->viewBase.'.referral-detail.include.application_card', $this->data);
	        }

	        $this->data['active_menue'] = 'referrals';

	        //dd($this->data['applications']);
	        //dd($this->data['job']->get_specialist_referral_sent_applications);
	        return view($this->viewBase.'.referral-detail.detail-page', $this->data);
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
        $this->data['applications'] = $this->job_application->where('job_id', $id)->where('refer_by', $my_id)->where('status', 'hired');
        $this->data['page'] = 'receive-detail';
        $this->data['active_menue'] = 'referrals';

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
            return view($this->viewBase.'.referral-detail.include.application_card', $this->data);
        }

        //dd($this->data['applications']);
        //dd($this->data['job']->get_specialist_referral_sent_applications);
        return view($this->viewBase.'.referral-detail.detail-page', $this->data);
       }else
       {
        return back()->with('error', 'Incorrect Url');  
       }
    }
    
    public function updateRating(){
        if(request()->ajax())
        {
            $input = request()->all();
            $udata = $this->job_application::where('id', $input['application_id'])->update(['rating_by_referee' =>  $input['rating']]);
            return json_encode(['success'=>true]);        
        }
    }

}
