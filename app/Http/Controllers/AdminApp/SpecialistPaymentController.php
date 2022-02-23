<?php

namespace App\Http\Controllers\AdminApp;

use App\Transformers\{SpecialistPaymentSummaryTransformer, SpecialistUnPaidPaymentTransformer, SpecialistPaidPaymentTransformer};
use App\Models\{PaymentHistory, Country};
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use App\Imports\PaymentHistoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SpecialistPaymentController extends Controller
{
    private $data = [];

	public function __construct()
	{
		$this->paymentHistory = new PaymentHistory();
		$this->countries = new Country();
		$this->data['active_menue'] = 'payments';
		$this->viewBasePath = 'payments';
	}

	//specialist payment summary
	public function paymentSummary()
	{
		if(request()->ajax())
    	{
    		$model = $this->paymentHistory->getSpecialistPayments();
            $model =  $model->select('payment_history.*')->with(['specilist']);

    		// filter by country from bank detail 
            if(request()->has('country') && !empty(request()->get('country')))
            {
                $location_id = request()->get('contry');
                $model = $model->where(function($query){
	             		    $query->whereHas('specilist.get_country_from_bank_detail', function($q){
	             				$q->where("country_id", request()->get('country'));
	             			});
             			 });
            }

            // filter By specilist name
            if(request()->has('name') && !empty(request()->get('name')))
            {
             	$model = $model->where(function($query){
             		    $query->whereHas('specilist', function($q){
             				$q->where("name","like","%".request()->get('name')."%");
             			});
             	});
            }

    		$obj = Datatables::eloquent($model)
                    ->filter(function($query){
                 })->setTransformer(new SpecialistPaymentSummaryTransformer(new PaymentHistory))
                  ->toJson();
            return $obj;        
    	}

    	$this->data['countries'] = $this->countries::where('status', 'active')->get(['id','name']);
    	$this->data['type'] = 'summary';
	    $this->data['active_sub_menue']= 'specialist-payments';
  		return view($this->viewBasePath.'.specialist.summary',$this->data);
	}

	//specialist unpaid payment
	public function unpaidPayments()
	{
		if(request()->ajax())
    	{
			$model = $this->paymentHistory->getSpecialistUnpaidPayments();
            $model =  $model->select('payment_history.*')->with(['job.position','job.company','job.primary_specialist', 'application','specilist']);

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


            // candidate name filter
            if(request()->has('candidate_name') && !empty(request()->get('candidate_name')))
            {
                $model = $model->whereHas('application',function($query){
                        $query->where("name","like","%".request()->get('candidate_name')."%");
                });
            }

            // filter By specialist name
            if(request()->has('name') && !empty(request()->get('name')))
            {
             	$model = $model->where(function($query){
             		    $query->whereHas('specilist', function($q){
             				$q->where("name","like","%".request()->get('name')."%");
             			});
             	});
            }

			$obj = Datatables::eloquent($model)
	                    ->filter(function($query){
	                 //status filter
                    	if(request()->has('payment_status') && !empty(request()->get('payment_status')))
                    	{   
                        	$query->where("is_paid","=", (request()->get('payment_status') == 'zero'? 0 : request()->get('payment_status')) );
                    	}   	
	                 })->setTransformer(new SpecialistUnPaidPaymentTransformer(new PaymentHistory))
	                  ->toJson();
	        return $obj;
	    }
	    
	    $this->data['type'] = 'unpaid';
	    $this->data['active_sub_menue']= 'specialist-payments';
  		return view($this->viewBasePath.'.specialist.unpaid',$this->data);
	}
	//specialist paid payments
	public function paidPayments()
	{
		if(request()->ajax())
    	{
			$model = $this->paymentHistory->getSpecialistPaidPayments();
            $model =  $model->select('payment_history.*')->with(['job.position','job.company','job.primary_specialist', 'application','specilist']);

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


            // candidate name filter
            if(request()->has('candidate_name') && !empty(request()->get('candidate_name')))
            {
                $model = $model->whereHas('application',function($query){
                        $query->where("name","like","%".request()->get('candidate_name')."%");
                });
            }

            // filter By referee name
            if(request()->has('name') && !empty(request()->get('name')))
            {
             	$model = $model->where(function($query){
             		    $query->whereHas('specilist', function($q){
             				$q->where("name","like","%".request()->get('name')."%");
             			});
             	});
            }

			$obj = Datatables::eloquent($model)
	                    ->filter(function($query){
	                 //status filter
                    	if(request()->has('payment_status') && !empty(request()->get('payment_status')))
                    	{   
                        	$query->where("is_paid","=", (request()->get('payment_status') == 'zero'? 0 : request()->get('payment_status')) );
                    	}

                    	if(request()->has('txn_id') && !empty(request()->get('txn_id')))
                    	{   
                        	$query->where("txn_id","=", request()->get('txn_id'));
                    	} 

	                 })->setTransformer(new SpecialistPaidPaymentTransformer(new PaymentHistory))
	                  ->toJson();
	        return $obj;
	    }
	    
	    $this->data['type'] = 'paid';
	    $this->data['active_sub_menue']= 'specialist-payments';
  		return view($this->viewBasePath.'.specialist.paid',$this->data); 
	}
	//specialist import csv page
	public function paymentStatus()
	{
		return view($this->viewBasePath.'.specialist.payment-status-update',$this->data);
	}
	//update payment status by csv
	public function updatePaymentStatus()
	{
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
 	//specialist unpaid payment detail 
 	public function unpaidPaymentDetail($id)
 	{
 		$data = $this->paymentHistory->where('id', $id)
                   ->where(function($query){
                    $query->where('user_type', 'specialist');
                   })
                   ->where('is_paid','!=', 1)
                   ->first();

        if(!empty($data))
        {   $this->data['payment']  = $data;
            $this->data['active_sub_menue']= 'specialist-payments';
            return view($this->viewBasePath.'.specialist.unpaid-payment-detail', $this->data);
        }
        return back()->with('error', 'Incorrect Url');  
 	}
 	//specialist paid payment detail 
 	public function paidPaymentDetail($id)
 	{
 		$data = $this->paymentHistory->where('id', $id)
                   ->where(function($query){
                    $query->where('user_type', 'specialist');
                   })
                   ->where('is_paid','=', 1)
                   ->first();

        if(!empty($data))
        {   $this->data['payment']  = $data;
            $this->data['active_sub_menue']= 'specialist-payments';
            return view($this->viewBasePath.'.specialist.paid-payment-detail', $this->data);
        }
        return back()->with('error', 'Incorrect Url'); 
 	}
 	 //update payment status
    public function paymentStatusUpdate()
    {
        $id = request()->input('id');
        if($id)
        {
            $this->paymentHistory->where('id', $id)->update(['is_paid'=>request()->input('payment_status')]);
            request()->session()->flash('success','Successfully updated payment status.');
            return redirect()->route('admin.specialist-paid-payments');
        }
        request()->session()->flash('error','Unexpected error occurred while trying to process your request.');
        return back();
    }
}
