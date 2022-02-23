<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PaymentHistory};
use App\Jobs\{SendPaymentStatusChangeEmailJob};

class CronJobController extends Controller
{	
	public $data = [];

    public function __construct(){
    	$this->paymentHistory = new PaymentHistory();
    }

    public function sentEmailToEmployer()
    {
    	$dta = $this->paymentHistory->where('user_type', 'admin')->where('by_csv', 1)->where('sent_email', 1)->select("*", \DB::raw('(CASE WHEN is_paid = "1" THEN "Paid" WHEN is_paid = "2" THEN "On Hold" WHEN is_paid = "3" THEN "Cancelled" ELSE "Unpaid" END) AS payment_status'))->get();

    	$this->data_setup($dta, "employer");

        dd('done');
    }

    public function sentEmailToReferee()
    {
        $dta = $this->paymentHistory->where(function($query)
                {
                    $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
                })->where('by_csv', 1)
                  ->where('sent_email', 1)
                  ->select("*", \DB::raw('(CASE WHEN is_paid = "1" THEN "Paid" WHEN is_paid = "2" THEN "On Hold" WHEN is_paid = "3" THEN "Cancelled" ELSE "Unpaid" END) AS payment_status'))
                  ->get();
        $this->data_setup($dta, "referee");          
                
        dd('done');
    }

    public function sentEmailToSpecialist()
    {
        $dta = $this->paymentHistory->where(function($query)
                {
                    $query->where('user_type', 'specialist');
                })->where('by_csv', 1)
                  ->where('sent_email', 1)
                  ->select("*", \DB::raw('(CASE WHEN is_paid = "1" THEN "Paid" WHEN is_paid = "2" THEN "On Hold" WHEN is_paid = "3" THEN "Cancelled" ELSE "Unpaid" END) AS payment_status'))
                  ->get();

         $this->data_setup($dta, "specialist");
         
         dd('done');         
    }


    private function data_setup($dta, $type)
    {
        foreach ($dta as $key => $value) 
        {   
            $this->data = [];
            $this->data['application_id'] = @$value->application->application_id??'';
            $this->data['candidate_name'] = @$value->application->name??'';
            $this->data['candidate_email'] = @$value->application->email??'';
            $this->data['candidate_mobile'] = @$value->application->mobile??'';
            $this->data['employer_name'] = @$value->job->company->company_name??'';
            $this->data['employer_email'] = @$value->job->employer->email??'';
            $this->data['position'] = @$value->job->position->name??'';
            $this->data['amount'] = @$value->amount??'';
            $this->data['txn_id'] = @$value->txn_id??'';
            $this->data['specilist'] = @$value->job->primary_specialist ? $value->job->primary_specialist->name : (@$value->job->secondary_specialist ? $value->job->secondary_specialist->name : '' );
            $this->data['commission'] = (@$value->commission) ? $value->commission.'%' : '-';
            $this->data['payment_status'] = @$value->payment_status??'';
            $this->data['type'] = $type;
            $this->data['referee_name'] = '';
            $this->data['referee_email'] = '';
            if($value->user_type == 'candidate')
            {
                $this->data['referee_name'] = $value->candidate->name??'';
                $this->data['referee_email'] = $value->candidate->email??'';  

            }elseif($value->user_type == 'referre-specialist'){
                $this->data['referee_name'] = $value->specilist->name??'';
                $this->data['referee_email'] = $value->specilist->email??'';
            }

            $this->data['specialist_name'] = @$value->specilist->name??'';
            $this->data['specialist_email'] = @$value->specilist->email??'';

            $email ='';

            if($type == 'referee')
            {
                 $this->data['subject'] = 'Referee Payment status change';
                 $email = $this->data['referee_email'];

            }elseif($type == 'specialist')
            {   $email = $this->data['specialist_email'];
                $this->data['subject'] = 'Specialist Payment status change';
            }elseif($type == 'employer')
            {   $email = $this->data['employer_email'];
                $this->data['subject'] = 'Employer Payment status change';
            }

             $mstatus =   SendPaymentStatusChangeEmailJob::dispatch($email, $this->data);

              if($mstatus)
              {
                 $dta = $this->paymentHistory->where('id', $value->id)->update(['sent_email' => '0']);
              }else{
                $dta = $this->paymentHistory->where('id', $value->id)->update(['sent_email' => '2']);
              }  
        } 
    } 

}
