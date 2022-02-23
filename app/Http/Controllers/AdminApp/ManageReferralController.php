<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Transformers\JobReferralApplicationsTransformer;
use App\Models\Job_application;
use App\Models\WorldLocation;

class ManageReferralController extends Controller
{
    public function listing()
    {		
    	if(request()->ajax())
    	{
            $model = Job_application::with(['job.position','job.company']);
            $model  = $model->whereNotNull('refer_by');

            // filter job id
            if(request()->has('job_id') && !empty(request('job_id')))
            {
                $model = $model->whereHas('job',function($query){
                    $query->where("job_id","like","%".request('job_id')."%");
                });
            }

            // position filter
            if(request()->has('position') && !empty(request('position')))
            {
                $model = $model->whereHas('job',function($query){
                    $query->whereHas('position',function($q)
                    {
                        $q->where("name","like","%".request('position')."%");
                    });
                });
            }

            // company name filter
            if(request()->has('company_name') && !empty(request('company_name')))
            {
                $model = $model->whereHas('job',function($query){
                    $query->whereHas('company',function($q)
                    {
                        $q->where("company_name","like","%".request('company_name')."%");
                    });
                });
            }

            // filter referee name filter
            if(request()->has('referee_name') && !empty(request('referee_name')))
            {
                $model = $model->whereHas('referred_by',function($query){
                    $query->where("name","like","%".request('referee_name')."%");
                });
            }

            // filter job location 
            if(request()->has('job_location') && !empty(request('job_location')))
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

            $obj = Datatables::eloquent($model)
                    ->filter(function($query){

                    	// application id filter
                        if(request()->has('application_id') && !empty(request('application_id')))
                        {   
                            $query->where("application_id","like","%".request('application_id')."%");
                        }

                        // application id filter
                        if(request()->has('applicant_name') && !empty(request('applicant_name')))
                        {   
                            $query->where("name","like","%".request('applicant_name')."%");
                        }

                    })->setTransformer(new JobReferralApplicationsTransformer(new Job_application))
                        ->toJson();
                    
            return $obj;
    	}	

    	$this->data['active_menue']= 'manage-referral';
    	return view('jobs.referrals.listing',$this->data);
    }

    public function view_detail($id)
    {
    	$this->data['obj_application'] = Job_application::where('id',$id)->firstOrFail();

        return view('jobs.referrals.view',$this->data);
    }
}
