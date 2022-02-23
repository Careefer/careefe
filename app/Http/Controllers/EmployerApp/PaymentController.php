<?php

namespace App\Http\Controllers\EmployerApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel; 
use App\{Candidate, Specialist};
use App\Models\{Specialist_jobs, Employer_jobs, Designation, EmployerDetail, Job_application, PaymentHistory};
use App\Exports\PaymentExport;

class PaymentController extends Controller
{
    protected $data;
    /*constructor*/
    public function __construct(){
    	$this->viewBasePath = 'employerApp.payments';
        $this->employer_jobs = new Employer_jobs();
        $this->job_application = new Job_application();
        $this->payment_history = new PaymentHistory();
        $this->candidate =  new Candidate();
    }
    /* job card listing page page*/
    public function listing()
    {
        $filters = request()->all();
        $this->data['jobs'] = $this->employer_jobs->whereHas('employerPaymentTranscations', function($query){
                $query->with('paymentHistory');
                //->where('is_paid', 1)
        });
        
        $this->data['filter_data'] = $filters;
        $this->data['active_menue'] = 'payments';

        if(!empty(request()->input('sortby')) && request()->input('sortby') == 'jobId')
        {
            $this->data['jobs'] = $this->data['jobs']->orderBy('job_id','desc');

        }elseif(!empty(request()->input('sortby')) && request()->input('sortby') == 'position')
        {
           $this->data['jobs'] = $this->data['jobs']->whereHas('position', function($query){
                    $query->orderBy('name', 'asc');
                });
        }elseif(!empty(request()->input('sortby')) && request()->input('sortby') == 'specialist')
        {
            $this->data['jobs'] = $this->data['jobs']->where(function($query){
                    $query->whereHas('primary_specialist', function($query){
                        $query->orderBy('name', 'asc');
                    })->orwhereHas('secondary_specialist', function($query){
                        $query->orderBy('name', 'asc');
                    });
                });
        }elseif(!empty(request()->input('sortby')) && request()->input('sortby') == 'applicant'){
            $this->data['jobs'] = $this->data['jobs']->whereHas('candidates', function($query){
                    $query->orderBy('name', 'asc');
                });
        }elseif(!empty(request()->input('sortby')) && request()->input('sortby') == 'status'){
            $this->data['jobs'] = $this->data['jobs']->orderBy('status', 'asc');
        }elseif(!empty(request()->input('sortby')) && request()->input('sortby') == 'total-paid'){
                $this->data['jobs'] = $this->data['jobs']->withCount([
                    'paymentHistory AS total_amount' => function ($query) 
                    {
                        $query->select(\DB::raw("SUM(amount) as total_amount"));
                    }
                ])->orderBy('total_amount', 'desc');

        }elseif(!empty(request()->input('sortby')) && request()->input('sortby') == 'total-pending'){
             $this->data['jobs'] = $this->data['jobs']->withCount([
                    'paymentHistory AS total_pending' => function ($query) 
                    {
                        $query->where('is_paid', 0)->select(\DB::raw("SUM(amount) as total_pending"));
                    }
                ])->orderBy('total_pending', 'desc');
        }elseif(!empty(request()->input('location')) && request()->input('location')!="")
        {
            $this->data['jobs'] = $this->data['jobs']->whereHas('country', function($query){
                    $query->orderBy('name', 'asc');
            });
        }

        $this->data['jobs'] = $this->data['jobs']->paginate(50);

        $this->data['filter_data'] = (request()->input('sortby') ? request()->input('sortby') : '');

        if(request()->ajax())
        {
        	return view($this->viewBasePath.'.include.job_card', $this->data);
        }      
        
    	return view($this->viewBasePath.'.main', $this->data);
    }

    public function paymentDetail($id)
    {
        $this->data['jobs'] = $this->employer_jobs::where('id', $id)->first();
        $this->data['applications'] = $this->job_application->employerPaymentHistory($id);

        if(!empty(request()->input('sortby')) && request()->input('sortby') == 'alphabetical')
        {
            $this->data['applications'] = $this->data['applications']->orderBy('name','asc');

        }else if(!empty(request()->input('sortby')) && request()->input('sortby') == 'alphabetical'){
            $this->data['applications'] = $this->data['applications']->whereHas('employerIsPayment', function($query){
                $query->orderBy('is_paid','asc');
            });
        }

        $this->data['filter_data'] = (request()->input('sortby') ? request()->input('sortby') : '');

        $this->data['applications'] = $this->data['applications']->paginate(50);

        $this->data['active_menue'] = 'payments';
        if(request()->ajax())
        {
            return view($this->viewBasePath.'.include.application_card', $this->data);
        }  
        return view($this->viewBasePath.'.detail', $this->data);
    }

    public function exportPayments($job_id)
    {
        $dta = $this->payment_history::where('job_id', $job_id)->where('user_type', 'admin')->first();
        return Excel::download(new PaymentExport($job_id), @$dta->job->job_id.'_Payment_Data.csv');
    }

}
