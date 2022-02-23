<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserCareerHistory extends Model
{   
    use SoftDeletes;
    
	protected $table = 'user_career_history';

    protected $fillable = [
                'user_id',
                'user_type',
                'company_name',
                'designation_id',
                'city_id',
                'state_id',
                'country_id',
                'job_skills',
                'roles_responsibilities',
                'start_date',
                'end_date',
                'is_current_company',
                'key_achievements',
                'additional_information'
                
    ];

    public $timestamp = true;


    public function designation(){
        return $this->belongsTo('App\Models\Designation', 'designation_id');
    }
}
