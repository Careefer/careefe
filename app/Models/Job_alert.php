<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job_alert extends Model
{	
    use SoftDeletes;
	
    protected $table = 'user_job_alerts';

    public $fillable = [
    					'email',
    					'ip',
    					'candidate_id',
    					'keyword',
    					'functional_area_ids',
    					'country_id',
    					'state_ids',
    					'city_ids',
    					'work_type_ids',
    					'referral_bonus_from',
    					'referral_bonus_to',
    					'salary_from',
    					'salary_to',
    					'position_ids',
    					'experience_from',
    					'experience_to',
    					'skill_ids',
    					'education_ids',
    					'industry_ids',
    					'company_ids'
    					];


        public function position()
        {   
            return $this->belongsTo("\App\Models\Designation",'position_ids');
        }

        /**
         * relation company detail
         */
        public function company()
        {   
            return $this->belongsTo("\App\Models\EmployerDetail",'company_ids');
        }
        
        public function industry()
        {
            return $this->belongsTo("\App\Models\Industry",'industry_ids');
        }                
}
