<?php

namespace App\Http\Controllers\AdminApp;

use App\Transformers\{RefereePaymentSummaryTransformer, RefereeUnPaidPaymentTransformer, RefereePaidPaymentTransformer};
use Yajra\DataTables\Facades\DataTables;
use App\Models\{PaymentHistory, Country};
use App\Imports\PaymentHistoryImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefereePaymentController extends Controller
{
    private $data = [];

	public function __construct()
	{
		$this->paymentHistory = new PaymentHistory();
		$this->countries = new Country();
		$this->data['active_menue'] = 'payments';
		$this->viewBasePath = 'payments';
	}
	//referee payment summary
	public function paymentSummary()
	{
		if(request()->ajax())
    	{
    		$model = $this->paymentHistory->getRefereePayments();

    		// filter by country from bank detail 
            if(request()->has('country') && !empty(request()->get('country')))
            {
                $location_id = request()->get('contry');
                $model = $model->where(function($query){
	             		    $query->whereHas('candidate.get_country_from_bank_detail', function($q){
	             			 $q->where("country_id", request()->get('country'));
	             			})->orwhereHas('specilist.get_country_from_bank_detail', function($q){
	             				$q->where("country_id", request()->get('country'));
	             			});
             			 });
            }

            // filter By referee name
            if(request()->has('name') && !empty(request()->get('name')))
            {
             	$model = $model->where(function($query){
             		    $query->whereHas('candidate', function($q){
             			 $q->where("name","like","%".request()->get('name')."%");
             			})->orwhereHas('specilist', function($q){
             				$q->where("name","like","%".request()->get('name')."%");
             			});
             	});
            }

    		$obj = Datatables::eloquent($model)
                    ->filter(function($query){
                 })->setTransformer(new RefereePaymentSummaryTransformer(new PaymentHistory))
                  ->toJson();
            return $obj;        
    	}

    	$this->data['countries'] = $this->countries::where('status', 'active')->get(['id','name']);
    	$this->data['type'] = 'summary';
	     $this->data['active_sub_menue']= 'referee-payments';
  		return view($this->viewBasePath.'.referee.summary',$this->data);
	}
	//referee unpaid payments
	public function unpaidPayment()
	{
		if(request()->ajax())
    	{
			$model = $this->paymentHistory->getRefereeUnpaidPayments();
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
             		    $query->whereHas('candidate', function($q){
             			 $q->where("name","like","%".request()->get('name')."%");
             			})->orwhereHas('specilist', function($q){
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
	                 })->setTransformer(new RefereeUnPaidPaymentTransformer(new PaymentHistory))
	                  ->toJson();
	        return $obj;
	    }
	    
	    $this->data['type'] = 'unpaid';
	    $this->data['active_sub_menue']= 'referee-payments';
  		return view($this->viewBasePath.'.referee.unpaid',$this->data);      
	}
	//referee paid payment
	public function paidPayment()
	{
		if(request()->ajax())
    	{
			$model = $this->paymentHistory->getRefereePaidPayments();
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
             		    $query->whereHas('candidate', function($q){
             			 $q->where("name","like","%".request()->get('name')."%");
             			})->orwhereHas('specilist', function($q){
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

	                 })->setTransformer(new RefereePaidPaymentTransformer(new PaymentHistory))
	                  ->toJson();
	        return $obj;
	    }
	    
	    $this->data['type'] = 'paid';
	   $this->data['active_sub_menue']= 'referee-payments';
  		return view($this->viewBasePath.'.referee.paid',$this->data); 
	}
	//referee csv import page
	public function paymentStatus()
	{
		return view($this->viewBasePath.'.referee.payment-status-update',$this->data);
	}
	//referee update payment status
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
    //unpaid payment detail page
    public function unpaidPaymentDetail($id)
    {
      $data = $this->paymentHistory->where('id', $id)
                   ->where(function($query){
                    $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
                   })
                   ->where('is_paid','!=', 1)
                   ->first();

        if(!empty($data))
        {   $this->data['payment']  = $data;
            $this->data['active_sub_menue']= 'referee-payments';
            return view($this->viewBasePath.'.referee.unpaid-payment-detail', $this->data);
        }
        return back()->with('error', 'Incorrect Url');  
    }
    //referee payment detail
    public function paidPaymentDetail($id)
    {
        $data = $this->paymentHistory->where('id', $id)
                   ->where(function($query){
                    $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
                   })
                   ->where('is_paid','=', 1)
                   ->first();

        if(!empty($data))
        {   $this->data['payment']  = $data;
            $this->data['active_sub_menue']= 'referee-payments';
            return view($this->viewBasePath.'.referee.paid-payment-detail', $this->data);
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
            return redirect()->route('admin.referee-unpaid-payment');
        }
        request()->session()->flash('error','Unexpected error occurred while trying to process your request.');
        return back();
    }

}
