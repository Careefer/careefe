<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Employer_jobs extends Model
{
    use SoftDeletes;
    
    protected $table = 'employer_jobs';

    protected $fillable = [
					        'job_id',
					        'employer_id',
                            'industry_id',
                            'company_id',
                            'industry_id',
					        'position_id',
					        'experience_min',
					        'experience_max',
					        'vacancy',
					        'skill_ids',
					        'salary_min',
					        'salary_max',
					        'summary',
					        'description',
					        'functional_area_ids',
					        'education_ids',
					        'work_type_id',
					        'commission_type',
					        'commission_amt',
                            'slug',
                            'country_id',
                            'state_ids',
                            'city_ids',
                            'referral_bonus_amt',
                            'specialist_bonus_amt',
                            'job_nature_id',
                            'primary_specialist_id',
                            'secondary_specialist_id',
                            'status',
                            'total_views',
                            'no_of_applications',
                            'specialist_bonus_percent',
                            'referral_bonus_percent',
					    ];


    /*
     * get next job id
     * 
     * @return string
     */
    public static function get_next_job_id()
    {
        $id = self::orderBy('id','desc')->value('id');

        $id = ($id)?$id+1:1;

        return 'CF-'.str_pad($id,9,"0",STR_PAD_LEFT);
    }

    /**
     * relation specialist name
     */
    public function specialist()
    {
    	return $this->belongsTo("App\Specialist", 'primary_specialist_id');
    }


    /**
     * relation specialist name
     */
    public function employer()
    {
        return $this->belongsTo("App\Employer");
    }

    /**
     * relation job country
     */
    public function country()
    {
    	return $this->belongsTo("App\Models\Country","country_id");
    }

    public function state()
    {
    	$job_id = $this->id;

    	$sql 	= DB::table('employer_job_locations AS A')
    				->leftJoin('world_states AS B','A.state_id','=','B.id')
    				->where(['A.employer_job_id'=>$job_id,'B.deleted_at'=>null,'B.status'=>'active'])
    				->orderBy('B.name')
    				->pluck('B.name','B.id');
		
		return ($sql->count())?$sql->toarray():[];			
    }

    public function cities()
    {
    	$job_id = $this->id;

    	$sql 	= DB::table('employer_job_location_cities AS A')
    				->leftJoin('world_cities AS B','A.city_id','=','B.id')
    				->where(['A.employer_job_id'=>$job_id,'B.deleted_at'=>null,'B.status'=>'active'])
    				->orderBy('B.name')
    				->pluck('B.name','B.id');
		
		return ($sql->count())?$sql->toarray():[];			
    }

    /**
     *relation work type
     */
    public function work_type()
    {
    	return $this->belongsTo("App\Models\work_type");
    }

    /**
     * Find skills
     */
    public function skills()
    {	
    	$skill_ids 	= $this->skill_ids;
    	$data 		= [];
    	if($skill_ids)
    	{
    		$id_arr = explode(',', $skill_ids);
    		$sql = \App\Models\skill::whereIn('id',$id_arr)->where(['status'=>'active'])->pluck('name','id');
    		if($sql)
    		{
    			$data = $sql->toarray();
    		}
    	}
    	return $data;
    }

    /**
     * Find educations
     */
    public function educations()
    {	
    	$education_ids 	= $this->education_ids;

    	$data 		= [];
    	if($education_ids)
    	{
    		$id_arr = explode(',', $education_ids);
    		$sql = \App\Models\Education::whereIn('id',$id_arr)->where(['status'=>'active'])->pluck('name','id');
    		if($sql)
    		{
    			$data = $sql->toarray();
    		}
    	}
    	return $data;
    }

    /**
     * Find Functional Area
     */
    public function functional_area()
    {	
    	$functional_area_ids 	= $this->functional_area_ids;

    	$data 		= [];
    	if($functional_area_ids)
    	{
    		$id_arr = explode(',', $functional_area_ids);
    		$sql = \App\Models\FunctionalArea::whereIn('id',$id_arr)->where(['status'=>'active'])->pluck('name','id');
    		if($sql)
    		{
    			$data = $sql->toarray();
    		}
    	}
    	return $data;
    }

    /**
     * get all added job's position
     */
    public static function  get_added_job_positions()
    {  
        $my_id = auth()->user()->id;

        $data = DB::table('employer_jobs AS A')
                    ->select('A.position_id','B.name')
                    ->leftJoin('designations AS B','A.position_id','=','B.id')
                    ->where(['A.deleted_at'=>null,'A.employer_id'=>$my_id])
                    ->groupBy('A.position_id')
                    ->get();

        return ($data->count()) ? $data:[];
    }

    /**
     * relation position/designation 
     */
    public function position()
    {   
        return $this->belongsTo("\App\Models\Designation",'position_id');
    }

    /**
     * relation company detail
     */
    public function company()
    {   
        return $this->belongsTo("\App\Models\EmployerDetail",'company_id');
    }

    /**
     * relation job nature
     */
    public function job_nature()
    {   
        return $this->belongsTo("\App\Models\Job_nature",'job_nature_id');
    }

    /**
     * relation industry
     */
    public function industry()
    {
        return $this->belongsTo("\App\Models\Industry",'industry_id');
    }

    /**
     * similar jobs
     */
    public function similar_jobs()
    {
        $obj = $this;
        $sql = Employer_jobs::orderBy('id','desc');

        //skill
        if($obj->skill_ids)
        {
            $ids_str    = implode('|', explode(',',$obj->skill_ids));
            $sql->whereRaw('CONCAT(",", skill_ids, ",") REGEXP ",('.$ids_str.'),"');
        }

        //functional area
        if($obj->functional_area_ids)
        {
            $ids_str    = implode('|', explode(',',$obj->functional_area_ids));

            $sql->whereRaw('CONCAT(",", functional_area_ids, ",") REGEXP ",('.$ids_str.'),"');
        }

        // work type
        if($obj->work_type_id)
        {
            $sql->where('work_type_id',$obj->work_type_id);
        }

        // location country
        if($obj->country_id)
        {
            $sql->where('country_id',$obj->country_id);
        }

        return $sql->get();
    }

    /**
     * relation primary specialist name
     */
    public function primary_specialist()
    {
        return $this->belongsTo("App\Specialist",'primary_specialist_id');
    }

    /**
     * relation secondary specialist name
     */
    public function secondary_specialist()
    {
        return $this->belongsTo("App\Specialist",'secondary_specialist_id');
    }

    public function applications(){
        return $this->hasMany('App\Models\Job_application', 'job_id')->count();
    }

    public function candidates(){
        return $this->hasMany('App\Models\Job_application', 'job_id');
    }

    //only for specilist
    public function specialist_referral_sent(){
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('specialist_id', $my_id)->count();
    }

    //only for specilist
    public function specialist_referral_recevie(){
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('specialist_id', $my_id)->where('status', 'hired')->count();
    }


    public function recommended()
    {
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('recommended_by', '!=', NULL)->count();
    }
    //only for specilist pannel
    public function get_specialist_referral_sent_applications()
    {
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('specialist_id', $my_id);
    }
    //only for specilist pannel
    public function get_specialist_referral_receive_applications(){
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('specialist_id', $my_id)->where('status', 'hired');
    }
    //application for employer
    public function emp_applications(){
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('specialist_id', '!=', NULL)->count();
    }

    //only for candidate pannel
    public function candidate_referral_sent_applications()
    {
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('refer_by', $my_id);
    }
    //only for candidate pannel
    public function candidate_referral_receive_applications()
    {
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('refer_by', $my_id)->where('status', 'hired');
    }

    public function paymentHistory()
    {   $my_id = my_id();
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','admin')->where('employer_id', $my_id);
    }


    public function getCandidatePaymentHistory($id=NULL)
    {
        $obj = $this;
        if(isset($id)){
            $obj =  $obj->where('id', $id);            
        }

        return $obj =  $obj->whereHas('candidate_referral_receive_applications.candidateIsPayment', function($q){
                $q->where('is_paid', 1);
            });
    }

    public function getCandidateTotalPayment(){
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type', 'candidate')->sum("amount");
    }

    public function getCandidateOutstandingPayment()
    {
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type', 'candidate')->where('is_paid', 0)->sum("amount");
    }

    public function getSpecialistTotalPayment()
    {
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','specialist')->sum("amount");
    }

    public function getSpecialistOutstandingPayment()
    {
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','specialist')->where('is_paid', 0)->sum("amount");
    }

    public function employerPaymentTranscations()
    {   $my_id = my_id();
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type', 'admin')->where('employer_id', $my_id);
    }

    public function employerTotalPayment()
    {   $my_id = my_id();
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','admin')->where('employer_id', $my_id)->sum("amount");
    }


    public function employerOutstandingPayment()
    {   $my_id = my_id();
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','admin')->where('is_paid', 0)->where('employer_id', $my_id)->sum("amount");
    }
    public function emp_total_hired(){
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('specialist_id', '!=', NULL)->where('status', 'hired')->count();
    }


    //only for specilist pannel (referral payments)
    public function referre_referral_receive_applications()
    {
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('refer_by_specilist', $my_id)->where('status', 'hired');
    }

    //only for specilist pannel (referral payments)    
    public function getSpecilistAsReferrePaymentHistory($id=NULL)
    {
        $obj = $this;
        if(isset($id)){
            $obj =  $obj->where('id', $id);            
        }

        return $obj =  $obj->whereHas('referre_referral_receive_applications.refereSpecialistIsPayment', function($q){
                $q->where('is_paid', 1);
            });
    }

    //only for specilist pannel (referral payments)
    public function referre_referral_sent_applications()
    {
        $my_id = my_id();
        return $this->hasMany('App\Models\Job_application', 'job_id')->where('refer_by_specilist', $my_id);
    }
    //only for specilist pannel (referral payments)
    public function getReferreSpecialistTotalPayment()
    {
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','referre-specialist')->sum("amount");
    }
    //only for specilist pannel (referral payments)    
    public function getReferreSpecialistOutstandingPayment()
    {
        return $this->hasMany('App\Models\PaymentHistory', 'job_id')->where('user_type','referre-specialist')->where('is_paid', 0)->sum("amount");
    }

    public function getApplications($job_staus = [])
    {
        $resp =  $this->hasMany('App\Models\Job_application', 'job_id');

        if(is_array($job_staus) && count($job_staus) > 0)
        {  
            $resp->whereIn('status',$job_staus);
        }

        return $resp;
    }

    public function jobSpecialist(){
        return $this->hasOne('App\Models\Specialist_jobs', 'job_id');
    }

}
