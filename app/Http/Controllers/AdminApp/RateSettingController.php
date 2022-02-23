<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RateSetting;
use App\Models\{RatingBounsWeight, SuccessRate};

class RateSettingController extends Controller
{
	protected $data = [];

    public function __construct(){
		$this->data['active_menue'] = 'rate-setting';
		$this->rateSetting =  new RateSetting();
		$this->ratingBounsWeight = new RatingBounsWeight();
		$this->viewBase = 'rate-setting';
		$this->successRate = new SuccessRate();
	}

	public function rateSetting($type){
		if(!empty($type)){
			switch ($type){
			case 'specialist':
				$this->data['rate_setting'] = $this->getData("specialist");
				$this->data['page'] = 'Specialist';
				$this->data['active_sub_menue']= 'specialist-rate-setting';
				break;
			case 'referee' :
				$this->data['rate_setting'] = $this->getData("referee");
				$this->data['page'] = 'Referee';
				$this->data['active_sub_menue']= 'referee-rate-setting';
				break; 
			default:
				return back()->with('error', 'Invalid Url');
				break;
			}
			return view($this->viewBase.'.setting', $this->data);
		}else{
			return back()->with('error', 'Invalid Url');
		}
	}


	private function getData($type){
		return	$this->rateSetting::where('type', $type)->first();
	}

	public function updateRateSetting(Request $request)
	{	
		$input = $request->all();
		$dta = $this->rateSetting::find($input['id']);
		$dta->application_weight = $input['application_weight'];
		$dta->job_fill_weight = $input['job_fill_weight'];
		$dta->update();
		return back()->with('success', 'Rate updated successfully.');
	}


	public function bounsRatingSetting(){
	  $this->data['rating']  = $this->ratingBounsWeight::get()->toArray();
	  $this->data['page'] = 'Referee';
	  $this->data['active_sub_menue']= 'referee-bouns-rate-setting';
	  return view($this->viewBase.'.rating-bouns-setting', $this->data);
	}

	public function updateBounsRating(Request $request){
		$input = $request->all();
		foreach ($input as $key => $value) {
			if($key!='_token'){
				$this->ratingBounsWeight::where('id', $key)->update(['bouns_rate'=>$value]); 	
			}
		}
		return back()->with('success', 'Bouns Rate updated successfully.');
	}

	public function successRateSetting(){
	  $this->data['rating']  = $this->successRate::get()->toArray();
	  $this->data['page'] = 'Referee';
	  $this->data['active_sub_menue']= 'referee-success-rate-setting';
	  return view($this->viewBase.'.success-rate-setting', $this->data);	
	}

	public function updateSuccessRateSetting(Request $request)
	{
		$input = $request->all();
		foreach ($input as $key => $value) {
			if($key!='_token'){
				$this->successRate::where('id', $key)->update(['rate'=>$value]);
			}
		}
		return back()->with('success', 'Success Rate updated successfully.');
	}

}
