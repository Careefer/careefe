<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RateSetting;
use App\Models\Employer_jobs;
use App\Models\{RatingBounsWeight, SuccessRate};   

class Job_application extends Model
{	
    use SoftDeletes;

    protected $table = 'job_applications';

    public $fillable = [
    					'job_id',
                        'candidate_id',
                        'application_id',
    					'name',
    					'email',
    					'mobile',
    					'current_company',
    					'resume',
    					'cover_letter',
                        'applied_by',
    					'refer_by',
                        'recommended_by',
                        'specialist_id',
                        'specialist_personal_notes',
                        'status'
    					];

    // public function getStatusAttribute($value) {
    //     if($value == 'applied') {
    //         return 'Applied';
    //     }else if($value == 'in_progress'){
    //         return 'In Process';
    //     }else if($value == 'unsuccess'){
    //         return 'Unsuccess';
    //     }else if($value == 'success'){
    //         return 'Success';
    //     }else if($value == 'candidate_declined'){
    //         return 'Candidate Declined';
    //     }else if($value == 'hired'){
    //         return 'Hired';
    //     }else if($value == 'cancelled'){
    //         return 'Cancelled';
    //     }else if($value == 'in_progress_with_employer'){
    //         return 'In Progress With Employer';
    //     }
    // }                   
    // relation job
    public function job()
    {   
        return $this->belongsTo('\App\Models\Employer_jobs','job_id', 'id');
    } 

    public function jobData()
    {   
        return $this->belongsTo('\App\Models\Employer_jobs','job_id', 'id');
    } 

    // relation candidate
    public function candidate()
    {   
        return $this->belongsTo('\App\Candidate','candidate_id');
    }

    // relation candidate
    public function referred_by()
    {   
        return $this->belongsTo('\App\Candidate','refer_by');
    }        

    /*
     * get next application id
     * 
     * @return string
     */
    public static function getNextApplicationId()
    {
        $application_id = Job_application::orderBy('id','desc')->value('id');

        $application_id = ($application_id)?$application_id+1:1;

        return 'CJA-'.str_pad($application_id,9,"0",STR_PAD_LEFT);
    }

    public function approved_jobs()
    {   $my_id = my_id();
        return $this->where('applied_by', $my_id)->where('refer_by', '!=', null)->select('*', \DB::raw('(CASE 
                        WHEN status = "applied" THEN "Applied"
                        WHEN status = "in_progress_with_employer" THEN "In Progress with Employer"
                        WHEN status = "in_progress" THEN "In Progress with Specialist"
                        WHEN status = "success" THEN "Success"
                        WHEN status = "unsuccess" THEN "Unsuccess"
                        WHEN status = "hired" THEN "Hired"
                        WHEN status = "candidate_declined" THEN "Candidate declined"
                        WHEN status = "cancelled" THEN "Cancelled" 
                        END) AS status'))->paginate(50);
    }

    public function candidateIsPayment()
    {
        return $this->hasOne('\App\Models\PaymentHistory','application_id')->where('user_type', 'candidate')->select("*", \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Paid"
                        WHEN is_paid = "2" THEN "On Hold"
                        WHEN is_paid = "3" THEN "Cancelled"
                        ELSE "Unpaid" 
                        END) AS payment_status'), \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Amount"
                        ELSE "Due" 
                        END) AS payment_status_label'));
    }

    public function candidatePaymentHistory($jobId)
    {
        return $this->whereHas('candidateIsPayment')->where('job_id', $jobId);
    }

    public function specialistIsPayment()
    {
        return $this->hasOne('\App\Models\PaymentHistory','application_id')->where('user_type', 'specialist')->select("*", \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Paid"
                        WHEN is_paid = "2" THEN "On Hold"
                        WHEN is_paid = "3" THEN "Cancelled"
                        ELSE "Unpaid" 
                        END) AS payment_status'), \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Amount"
                        ELSE "Due " 
                        END) AS payment_status_label'));
    }

     public function specialistPaymentHistory($jobId)
    {   $my_id = my_id();
        return $this->whereHas('specialistIsPayment')->where('job_id', $jobId)->where('specialist_id', $my_id)->where('status', 'hired');
    }

    public function employerIsPayment()
    {
        return $this->hasOne('\App\Models\PaymentHistory','application_id')->where('user_type', 'admin')->select("*", \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Paid"
                        WHEN is_paid = "2" THEN "On Hold"
                        WHEN is_paid = "3" THEN "Cancelled"
                        ELSE "Unpaid" 
                        END) AS payment_status'), \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Amount"
                        ELSE "Outstanding" 
                        END) AS payment_status_label'));
    }

    public function employerPaymentHistory($jobId)
    {   return $this->whereHas('employerIsPayment')->where('job_id', $jobId)->where('status', 'hired');
    }

    public function refereSpecialistIsPayment()
    {
        return $this->hasOne('\App\Models\PaymentHistory','application_id')->where('user_type', 'referre-specialist')->select("*", \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Paid"
                        WHEN is_paid = "2" THEN "On Hold"
                        WHEN is_paid = "3" THEN "Cancelled"
                        ELSE "Unpaid" 
                        END) AS payment_status'), \DB::raw('(CASE 
                        WHEN is_paid = "1" THEN "Amount"
                        ELSE "Due " 
                        END) AS payment_status_label'));
    }

    public function referrePaymentHistory($jobId)
    {   $my_id = my_id();
        return $this->whereHas('refereSpecialistIsPayment')->where('job_id', $jobId)->where('specialist_id', $my_id)->where('status', 'hired');
    }

    public function specialistCommissionCalculate($app_object, $salary)
    {   

        $careefer_commission = 0;
        $specialist_commission_max = 0;
        $job_fill_weight_amount = 0;
        $application_weight_amount = 0;
        $data = [];
        //get careefer commission data
        $careefer_commission_data = $this->careeferCommissionCalculate($app_object, $salary);

        if(!empty($careefer_commission_data)){
            //assign careefer commission
            $careefer_commission = $careefer_commission_data['careefer_commission_amount'];
        }
    
        if($careefer_commission>0)
        {  // specialist max commission 
           $specialist_commission_max  = ($careefer_commission * $app_object->job->specialist_bonus_percent)/100;
           //now devide speclist max commision in two parts as per alogrithm 
           $specialist_ratio = RateSetting::where('type', 'specialist')->first(); 
           if(!empty($specialist_ratio))
           {    // application weight percentage
                $data['application_weight'] = $specialist_ratio['application_weight'];
                // job fill weight percentage
                $data['job_fill_weight'] = $specialist_ratio['job_fill_weight'];
                // application weight amount => (spaclist_max_amount  * application_weight/100)    
                $application_weight_amount =  ($specialist_ratio['application_weight'] * $specialist_commission_max)/100;
                //max job fill weight amout
                $job_fill_weight_amount = ($specialist_ratio['job_fill_weight'] * $specialist_commission_max)/100;
                //get job fill score for specialist
                $specialistScore = $this->getSpecialistJobScore($app_object->specialist_id);
                // job fill weight amount
                $job_fill_amount = ($specialistScore['job_score'] *  $job_fill_weight_amount)/100;
           }
        }

        //fill data
        $data['salary'] = $salary;
        $data['application_id'] = $app_object->id;
        $data['job_id'] = $app_object->job->id; 
        $data['careefer_commission_type'] = $app_object->job->commission_type;
        $data['careefer_commission_amount'] =  $careefer_commission;
        $data['specialist_commision_percentage'] = @$app_object->job->specialist_bonus_percent;
        $data['specialist_commission_max'] =  $specialist_commission_max;
        $data['application_weight_amount'] = $application_weight_amount;
        $data['job_fill_weight_amount'] = $job_fill_amount; 
        return $data;
    }


    public function careeferCommissionCalculate($app_object, $salary){
        $careefer_commission = 0;
        $data = [];
        //carefer commission calculation
        if($app_object->job->commission_type == 'percentage'){
            $careefer_commission = ($salary * $app_object->job->commission_amt)/100;
        }else{
            $careefer_commission = $app_object->job->commission_amt;
        }

        $data['salary'] = $salary;
        $data['application_id'] = $app_object->id;
        $data['job_id'] = $app_object->job->id; 
        $data['careefer_commission_type'] = $app_object->job->commission_type;
        $data['careefer_commission'] = $app_object->job->commission_amt;
        $data['careefer_commission_amount'] =  $careefer_commission;

        return $data;
    }

    public function refereeCommissionCalculate($app_object, $salary, $candidate_type)
    {    
         $careefer_commission = 0;
         $referee_commission_max = 0;
         $job_fill_weight = 0;
         $application_weight_amount = 0;
         $application_weight_max_amount = 0;
         $job_fill_weight_max_amount = 0;
         $job_fill_weight_amount = 0;

         $data = [];
         $history_data = [];

         if($app_object->refer_by == NULL){
            return [];
         }

         $careefer_commission_data = $this->careeferCommissionCalculate($app_object, $salary);

         if(!empty($careefer_commission_data)){
            $careefer_commission = $careefer_commission_data['careefer_commission_amount'];
         }
        if($careefer_commission>0)
        {   // referee max commision from careefer commission 
            $referee_commission_max  = ($careefer_commission * $app_object->job->referral_bonus_percent)/100;
            //get application weight and job fill weight ratio
            $refree_ratio = RateSetting::where('type', 'referee')->first();

            if(!empty($refree_ratio))
            {
                $data['application_weight'] = $refree_ratio['application_weight'];

                $data['job_fill_weight'] = $refree_ratio['job_fill_weight'];
                //get application weight max amount
                $application_weight_max_amount =  ($refree_ratio['application_weight'] * $referee_commission_max)/100;
                //get job fill max amount
                $job_fill_weight_max_amount = ($refree_ratio['job_fill_weight'] * $referee_commission_max)/100;
                
                //get Candidate weight percent from candidate rating bouns weight
                if($app_object->rating_by_referee){
                    $rating_bouns = RatingBounsWeight::where('rating', $app_object->rating_by_referee)->select('bouns_rate')->first();
                }else{
                     $rating_bouns = RatingBounsWeight::where('rating', 'Unrated')->select('bouns_rate')->first();
                }
                // calculate Particular Candidate Referral
                if($application_weight_max_amount)
                {  
                    $application_weight_amount =  ($application_weight_max_amount * $rating_bouns['bouns_rate'])/100;
                }
                //calculate Referral History
                if($job_fill_weight_max_amount)
                {

                 if($candidate_type=='specialist')
                 {
                    $type = 'refer_by_specilist';
                    //get Referral History data
                    $history_data =  $this->getRefeeredApplications($app_object->refer_by, $type);
                 }else
                 {   $type = 'refer_by';   
                     //get Referral History data
                     $history_data =  $this->getRefeeredApplications($app_object->refer_by, $type);
                 }
                 
                 $total_referred = 0;
                 $sum_of_penalty_x_referred = 0;
                 $job_fill_final_data = [];
                 if(!empty($history_data))
                 {      
                    foreach ($history_data as $key => $value) {
                        $dta =[];
                        //get expected rate ratio from success rate table behalf of rating
                        if($value['rating_by_referee']){
                          $dta =  SuccessRate::where('rating', $value['rating_by_referee'])->first(['rating', 'rate']);
                        }else{
                            $dta =  SuccessRate::where('rating', 'unrated')->first(['rating', 'rate']);
                        }
                       //get success rate => (success/total_refered * 100) in percentage 
                       $history_data[$key]['success_rate'] = $success_rate = ($value['successful']/$value['total_referred']) * 100;
                       //expected success rate from success rate table
                       $history_data[$key]['expected_success_rate'] =  $expected_rate = ($dta['rate'])??0;
                       // get panalty =>  (expected success rate - success_rate)
                       $history_data[$key]['penalty'] = $penalty = abs(($expected_rate - $success_rate));
                       // get penalty_x_referred with round off => penalty * Referred 
                       $history_data[$key]['penalty_x_total_referred']  = round(($penalty/100) * $value['total_referred']);
                       //get penalty_x_referred without round off value => (penlaty * referred)   
                       $calc_amount = ($penalty/100) * $value['total_referred'];
                       //sum of refered applications => =+ referred 
                       $total_referred = $total_referred + $value['total_referred'];
                       //sum of penalty_x_referred => =+ penalty_x_referred without round off value  
                       $sum_of_penalty_x_referred = $sum_of_penalty_x_referred + $calc_amount;
                    }
                    $job_fill_final_data['total_referred'] = $total_referred;
                    $job_fill_final_data['sum_of_penalty_x_referred'] = $sum_of_penalty_x_referred;
                    //weighted_average_penalty => sum_of_penalty_x_referred / total refered into percentage
                    $job_fill_final_data['weighted_average_penalty'] = $weighted_average_penalty =   round(($sum_of_penalty_x_referred/ $total_referred) * 100, 2);
                    //bouns rate in percentage so => 100 - penalty 
                    $job_fill_final_data['bouns_rate'] = $bouns_rate =  (100 - $weighted_average_penalty);
                    // referee job fill weight amount
                    $job_fill_weight_amount  =  round(($job_fill_weight_max_amount * $bouns_rate/100),2); 
                 }else{
                    $job_fill_weight_amount  = $job_fill_weight_max_amount;
                 }

                }
            } 
        }

        //fill data
        $data['salary'] = $salary;
        $data['application_id'] = $app_object->id;
        $data['job_id'] = $app_object->job->id; 
        $data['careefer_commission_type'] = $app_object->job->commission_type;
        $data['careefer_commission_amount'] =  $careefer_commission;
        $data['referee_commision_percentage'] = @$app_object->job->referral_bonus_percent;
        $data['referee_commission_max'] =  $referee_commission_max;
        $data['application_weight_amount'] = $application_weight_amount;
        $data['job_fill_weight_amount'] = $job_fill_weight_amount;
        $data['history']  = $history_data;
        $data['job_fill_final_data']  = $job_fill_final_data;
        return $data;
    }

    public function getSpecialistJobScore($specialist_id){
        //get all job assign to this specilist with applications
        $job = Employer_jobs::where(function($query) use ($specialist_id){
            $query->where('primary_specialist_id', $specialist_id)->orwhere('secondary_specialist_id', $specialist_id);
        })
        ->whereIn('status', ['active','closed'])
        ->whereHas('getApplications', function($query) use($specialist_id){
            $query->where('status', '!=', 'applied')->where('specialist_id', $specialist_id);
        });
        //count of total jobs
        $total_job_assign_count = $job->get(['id'])->pluck('id')->count();  
        //count of success job => (job with hired application)   
        $job_success_count = $job->whereHas('getApplications', function($query){
                                 $query->where('status', 'hired');    
                            })
                            ->get(['id'])->pluck('id')->count();
        //default score 
        $job_score = 100;                    
        //calculate score
         if($total_job_assign_count  > 0){
            $job_score =  ($job_success_count/ $total_job_assign_count) * 100 ;
         }                   

         return ['total_job_assign' => $total_job_assign_count, 'job_success'=> $job_success_count, 'job_score'=>$job_score];

    }


    protected function getRefeeredApplications($refeer_by, $type){
             return $this->where($type, $refeer_by)
               ->whereHas('job', function($query){
                $query->where('status','closed'); 
              })
              ->whereNotIn('status', ['applied','in_progress'])
              ->select(['rating_by_referee',\DB::raw('SUM(IF(status="hired" || status="success",1,0)) as successful'), \DB::raw('SUM(IF(status<>"hired" && status<>"success" && status<>"candidate_declined" && status<>"applied" && status<>"in_progress", 1,0)) as unsuccessful'), \DB::raw('COUNT(status) as total_referred')])
              ->groupBy('rating_by_referee')
              ->orderBy('rating_by_referee', 'desc')
              ->get()
              ->toArray();
    }

}
