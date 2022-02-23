<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class EmployerDetail extends Model
{	
    use SoftDeletes;
	
    protected $table = 'employer_detail';

    public $fillable = [
    					'employer_id',
    					'company_name',
                        'slug',
    					'logo',
    					'head_office_location_id',
    					'industry_id',
    					'size_of_company',
    					'website_url',
    					'about_company',
                        'is_featured',
                        'status'
    					];
    

    /*
     * get next candidate id
     * 
     * @return string
     */
    public static function getNextEmployerId()
    {
        $employer_id = EmployerDetail::orderBy('id','desc')->value('id');

        $employer_id = ($employer_id)?$employer_id+1:1;

        return 'EMP-'.str_pad($employer_id,9,"0",STR_PAD_LEFT);
    }
    
    /**
     * get all  branches
     */
    public function branch_locations()
    {   
        $company_id = $this->id;
    
        $data = DB::table('employer_branch_offices AS A')
                ->leftJoin('world_location AS B','A.location_id','=','B.id')
                ->where(['A.employer_id'=>$company_id,'B.status'=>'active'])    
                ->pluck('B.location','B.id');
        
        return $data;                    
    }

    /**
     * relation to get head offfice
     */
    public function head_office()
    {
        return $this->belongsTo("App\Models\WorldLocation","head_office_location_id")->where(['status'=>'active']);
    }

    /**
     * relation to get industry
     */
    public function industry()
    {
        return $this->belongsTo("App\Models\Industry","industry_id")->where(['status'=>'active']);
    }

    public function employees()
    {
        return $this->hasMany('App\Employer','company_id','id');
    }

    // relation active jobs
    public function active_jobs()
    {
        return $this->hasMany('App\Models\Employer_jobs','company_id','id')->where(['status'=>'active'])->orderBy('id','desc');
    }

    // find top most job's companies
    public static function top_most_companies($country_id,$city_id_arr = null,$industry_arr = null)
    {  
        $data = [];
        $where = ['B.status'=>'active','B.deleted_at'=>null,'A.country_id'=>$country_id];

        $obj = DB::table('employer_branch_offices AS A')
                ->join('employer_detail AS B','A.employer_id','=','B.id')
                ->select('B.id','B.company_name','B.slug','B.total_active_jobs','A.city_id')
                ->where($where)
                ->orderBy('B.total_active_jobs','desc')
                ->groupBy('A.employer_id')
                ->take(10);

        if($city_id_arr)
        {   
            $obj->whereIn('A.city_id',$city_id_arr);
        }

        if($industry_arr)
        {   
            $obj->whereIn('B.industry_id',$industry_arr);
        }    
        
        $sql = $obj->get();

        if($sql->count())
        {   
            $data = $sql->toarray();
        }

        return $data;            
    } 
}
