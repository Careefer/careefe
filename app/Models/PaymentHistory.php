<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReferralPaymentHistoryLog;

class PaymentHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_history';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'application_id',
                  'job_id',
                  'user_type',
                  'amount',
                  'is_paid',
                  'user_id',
                  'txn_id',
                  'commission',
                  'employer_id',
                  'by_csv',
                  'sent_email',
                  'commission_max_amount',
                  'application_weight',
                  'job_fill_weight',
                  'application_weight_amount',
                  'job_fill_weight_amount',
                  'careefer_commission_type',
                  'careefer_commission_amount',
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    public function job()
    {
      return $this->belongsTo('App\Models\Employer_jobs', 'job_id');
    }

    public function application(){
      return $this->belongsTo('App\Models\Job_application', 'application_id');
    } 
    
    public function specilist(){
      return $this->belongsTo('App\Specialist', 'user_id');
    }

    public function candidate(){
     return $this->belongsTo('App\Candidate', 'user_id'); 
    }

    public function getCandidatePayments()
    {
      return $this->where(function ($query){
                    $query->where('user_type', '=', 'candidate')
                      ->orWhere('user_type', '=', 'referre-specialist');
              });
    }
    //for employer payment
    public function getEmployerPayments()
    {
      return $this->where('user_type', 'admin')->where('is_paid', 1)->groupBy('job_id');
    }
    //for employer payment
    public function employerTotalPayments(){
      return $this->where('user_type', 'admin')->groupBy('job_id')->sum('amount');
    }
    //for employer payment
    public function employerTotalOutstandingPayments(){
      return $this->where('user_type', 'admin')->where('is_paid', 0)->groupBy('job_id')->sum('amount');
    }

    public function getEmployerPaidPayments(){
      return $this->where('user_type', 'admin')->where('is_paid', 1);
    }

    public function getEmployerUnPaidPayments(){
      return $this->where('user_type', 'admin')->where('is_paid','!=', 1); 
    }
    //for referee payments
    public function getRefereePayments()
    {
      return $this->where(function($query){
        $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
      })->where('is_paid', 1)->groupBy('user_type','user_id');
    }

    //for referee payment
    public function refereeTotalPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
      })->groupBy('user_type','user_id')->sum('amount');
    }
    //for referee payment
    public function refereeTotalOutstandingPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
      })->where('is_paid', 0)->groupBy('user_type','user_id')->sum('amount');
    }

    public function getRefereeUnpaidPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
      })->where('is_paid', '!=', 1);
    }

    public function getRefereePaidPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'candidate')->orwhere('user_type', 'referre-specialist');
      })->where('is_paid', '=', 1);
    }

    //for referee payments
    public function getSpecialistPayments()
    {
      return $this->where(function($query){
        $query->where('user_type', 'specialist');
      })->where('is_paid', 1)->groupBy('user_id');
    }


    //for Specialist payment
    public function specialistTotalPayments()
    {
      return $this->where(function($query){
        $query->where('user_type', 'specialist');
      })->groupBy('user_id')->sum('amount');
    }
    //for Specialist payment
    public function specialistTotalOutstandingPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'specialist');
      })->where('is_paid', 0)->groupBy('user_id')->sum('amount');
    }

    public function getSpecialistUnpaidPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'specialist');
      })->where('is_paid', '!=', 1);
    }

    public function getSpecialistPaidPayments(){
      return $this->where(function($query){
        $query->where('user_type', 'specialist');
      })->where('is_paid', '=', 1);
    }


    public static function savePaymentTransaction($application, $dta, $user_type){
        $pdata = new PaymentHistory();
        $pdata->application_id = $dta['application_id'];
        $pdata->job_id = $dta['job_id'];
        $pdata->user_type = $user_type;

        if($user_type == 'candidate' || $user_type == 'referre-specialist')
        {   
            if($user_type == 'candidate')
            {
                $pdata->user_id = $application->refer_by;

            }elseif($user_type == 'referre-specialist')
            {
                $pdata->user_id = $application->refer_by_specilist;
            }
            
            $pdata->commission = $dta['referee_commision_percentage'];
            $pdata->commission_max_amount = $dta['referee_commission_max'];
        
            if(!empty($dta['job_fill_final_data']))
            {
                $pdata->total_referred = $dta['job_fill_final_data']['total_referred'];
                $pdata->sum_of_penalty_x_referred = $dta['job_fill_final_data']['sum_of_penalty_x_referred'];
                $pdata->weighted_average_penalty = $dta['job_fill_final_data']['weighted_average_penalty'];
                $pdata->bouns_rate = $dta['job_fill_final_data']['bouns_rate'];
            }
        }

        if($user_type == 'specialist'){
            $pdata->user_id = (@$application->job->primary_specialist_id)??@$application->job->secondary_specialist_id;
            $pdata->commission = $dta['specialist_commision_percentage'];
            $pdata->commission_max_amount = $dta['specialist_commission_max'];
        }

        if($user_type != 'admin'){
          $pdata->amount =  ($dta['application_weight_amount'] + $dta['job_fill_weight_amount']);
          $pdata->application_weight = $dta['application_weight'];
          $pdata->job_fill_weight = $dta['job_fill_weight']; 
          $pdata->application_weight_amount = $dta['application_weight_amount'];
          $pdata->job_fill_weight_amount =  $dta['job_fill_weight_amount'];
        }else{
            $pdata->amount = $dta['careefer_commission_amount'];
            $pdata->commission = $dta['careefer_commission'];
            $pdata->user_id = 1; 
        }
        
        $pdata->employer_id = $application->job->employer_id;
        $pdata->careefer_commission_type  = $dta['careefer_commission_type'];
        $pdata->careefer_commission_amount = $dta['careefer_commission_amount'];
        $pdata->is_paid = 0;

        $pdata->save();

        if($user_type == 'candidate' || $user_type == 'referre-specialist')
        {
            if(!empty($dta['history'])){
                $history = $dta['history'];
                foreach ($history as $key => $value) {
                    $value['payment_history_id'] = $pdata['id'];
                    ReferralPaymentHistoryLog::create($value);
                }
            }
        }

        return $pdata;
    } 


}
