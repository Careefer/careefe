<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PaymentHistoryImport;
use Yajra\DataTables\Facades\DataTables;
use App\Models\{PaymentHistory, WorldLocation};
use App\Transformers\{EmployerPaymentTransformer, EmployerPaidPaymentTransformer, EmployerUnPaidPaymentTransformer};

class PaymentController extends Controller
{
	private $data = [];

	public function __construct(){
		$this->paymentHistory = new PaymentHistory();
		$this->data['active_menue'] = 'payments';
	}


    public function employerPayment()
    {	
    	if(request()->ajax())
    	{
    		$model = $this->paymentHistory->getEmployerPayments();
            $model =  $model->select('payment_history.*')->with(['job.company']);

    		// filter job location 
            if(request()->has('job_location') && !empty(request()->get('job_location')))
            {   
                $location_id = request()->get('job_location');

                $obj_loc = WorldLocation::select('country_id','state_id','city_id')->where(['id'=>$location_id,'status'=>'active'])->orderBy('id','desc')->first();

                $model = $model->whereHas('job',function($query) use($obj_loc){

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

    		$obj = Datatables::eloquent($model)
                    ->filter(function($query){
                 })->setTransformer(new EmployerPaymentTransformer(new PaymentHistory))
                  ->toJson();
            return $obj;        
    	}
    	$this->data['type'] = 'summary';
	    $this->data['active_sub_menue']= 'employer-payments';
  		return view('payments.employer.listing-job-card',$this->data);
    }

    public function employerPaidPayment()
    {
    	if(request()->ajax())
    	{
	    	$model = $this->paymentHistory->getEmployerPaidPayments();
            $model =  $model->select('payment_history.*')->with(['job.position','job.company','job.primary_specialist', 'application']); 

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


            // candidate filter
            if(request()->has('candidate_name') && !empty(request()->get('candidate_name')))
            {
                $model = $model->whereHas('application',function($query){
                        $query->where("name","like","%".request()->get('candidate_name')."%");
                });
            }


	    	$obj = Datatables::eloquent($model)
	                    ->filter(function($query){

	                    //status filter
                        if(request()->has('payment_status') && !empty(request()->get('payment_status')))
                        {   
                            $query->where("is_paid","=", (request()->get('payment_status') == 'zero'? 0 : request()->get('payment_status')) );
                        }

                        //transaction Id filter
                        if(request()->has('transaction_id') && !empty(request()->get('transaction_id')))
                        {   
                            $query->where("txn_id","=",request()->get('transaction_id'));
                        } 	


	                 })->setTransformer(new EmployerPaidPaymentTransformer(new PaymentHistory))
	                  ->toJson();	          
	        return $obj;          
        }                    
     	$this->data['type'] = 'paid';     
        $this->data['active_sub_menue']= 'employer-payments';
  		return view('payments.employer.paid-payments-list',$this->data);
    }

    public function employerUnPaidPayment()
    {
    	if(request()->ajax())
    	{
	    	$model = $this->paymentHistory->getEmployerUnPaidPayments();
            $model =  $model->select('payment_history.*')->with(['job.position','job.company','job.primary_specialist', 'application']);

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


            // candidate filter
            if(request()->has('candidate_name') && !empty(request()->get('candidate_name')))
            {
                $model = $model->whereHas('application',function($query){
                        $query->where("name","like","%".request()->get('candidate_name')."%");
                });
            }


            // filter job location 
            if(request()->has('job_location') && !empty(request()->get('job_location')))
            {   
                $location_id = request()->get('job_location');

                $obj_loc = WorldLocation::select('country_id','state_id','city_id')->where(['id'=>$location_id,'status'=>'active'])->orderBy('id','desc')->first();

                $model = $model->whereHas('job',function($query) use($obj_loc){

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

	                    //status filter
                        if(request()->has('payment_status') && !empty(request()->get('payment_status')))
                        {   
                            $query->where("is_paid","=", (request()->get('payment_status') == 'zero'? 0 : request()->get('payment_status')) );
                        }

	                 })->setTransformer(new EmployerUnPaidPaymentTransformer(new PaymentHistory))
	                  ->toJson();	          
	        return $obj;          
        }                    
     	$this->data['type'] = 'unpaid';     
        $this->data['active_sub_menue']= 'employer-payments';
  		return view('payments.employer.unpaid-payments-list',$this->data);
    }

    public function unpaidPaymentDetail($id)
    {
    	$data = $this->paymentHistory->where('id', $id)->where('user_type', 'admin')->where('is_paid','!=', 1)->first();
    	if(!empty($data))
    	{	$this->data['payment']  = $data;
            $this->data['active_sub_menue']= 'employer-payments';
    		return view('payments.employer.unpaid-payment-detail', $this->data);
    	}
    	return back()->with('error', 'Incorrect Url');
    }

    public function paidPaymentDetail($id)
    {
    	$data = $this->paymentHistory->where('id', $id)->where('user_type', 'admin')->where('is_paid','=', 1)->first();
    	if(!empty($data))
    	{	$this->data['payment']  = $data;
            $this->data['active_sub_menue']= 'employer-payments';
    		return view('payments.employer.paid-payment-detail', $this->data);
    	}
    	return back()->with('error', 'Incorrect Url');	
    }

    public function paymentStatusUpdate()
    {
    	$id = request()->input('id');
    	if($id)
    	{
    		$this->paymentHistory->where('id', $id)->update(['is_paid'=>request()->input('payment_status')]);
    		request()->session()->flash('success','Successfully updated payment status.');
    		return redirect()->route('admin.employer-payment-unpaid');
    	}
    	request()->session()->flash('error','Unexpected error occurred while trying to process your request.');
    	return back();
    }

    public function paymentStatusUpdateByCSV()
    {
    	return view('payments.employer.payment-update-by-csv');
    }

    public function importPaymentCSV(){
    	if(request()->all())
        {  
                $file = request()->file('name');
                
                if(empty($file))
                { 
                    request()->session()->flash('error_notify','Please select file to import');
                    return redirect()->back();
                }
                
                $extension = $file->getClientOriginalExtension();

                if(!in_array(strtolower($extension), ['csv']))
                { 
                    request()->session()->flash('error','Please import only CSV file');
                    return redirect()->back();
                }

            try
            {   
                $file_name = request()->file('name')->getClientOriginalName();
            
                 Excel::import(new PaymentHistoryImport, request()->file('name'));

                request()->session()->flash('success_notify','Data imported successfully.');

            }
            catch(Exception $exception)
            {
                request()->session()->flash('error','Unexpected error occurred while trying to process your request.');
            }
            return redirect()->back();
        }
    }

}
