<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\skill as Skill;
use App\Models\EmployerDetail;
use App\Models\WorldLocation;
use App\Models\City;
use App\Models\Employer_jobs;
use App\Models\Job_application;
use App\Models\FunctionalArea;
use App\Models\work_type;
use App\Models\Education;
use App\Models\Industry;
use App\Models\Recent_job_search;

class JobController extends Controller
{	
    protected $data = [];

    public function save_recent_searched_job()
    {       
        $ip = request()->ip();
        
        $post = request()->all();

        unset($post['_token']);

        if(!$post)
        {
            return redirect()->back();
        }

        if(empty($post['l']))
        {   
            return redirect()->back()->withInput()->with('error_notify','Location can not be left blank');
        }

        if(isset($post['k']) && !empty($post['k']))
        {
            $total_record = $this->filter_jobs()->total();
       
            $user_id = null;

            if(isset(auth()->guard('candidate')->user()->id))
            {
                $user_id = auth()->guard('candidate')->user()->id;
            }

            $insert_arr = [
                            'user_id'       => $user_id,
                            'ip'            => request()->ip(),   
                            'total_result'  => $total_record,   
                        ];

            if($post['k'])
            {
                $key_slug = slug_url($post['k']);
                $insert_arr['string'] = ucwords(str_replace('-',' ',$key_slug));
            }
            if($post['l'])
            {
                $loc_slug = slug_url($post['l']);
                $insert_arr['location'] = ucwords(str_replace('-',' ',$loc_slug));
            }
            $post['k'] = !empty($key_slug) ? $key_slug:'';
            $post['f'] = [$post['f']]; 
            $post['l'] = !empty($loc_slug) ? $loc_slug:'';
            $insert_arr['slug'] = http_build_query($post);
            $obj =  Recent_job_search::where($insert_arr)->first();

            if($obj)
            {
                $obj->updated_at = GMT_DATE_TIME;
                $obj->save();
            }
            else
            {
                Recent_job_search::create($insert_arr);
            }                      
        }
        
        // Make functional area as array
        

        unset($post['_token']);
        $params = http_build_query($post);
        $url = route('web.job.search.listing').'?';    
        $url .=$params; 

        return redirect($url);
    }

    public function clearAllSearchedJobs(Request $request)
    {
        $ip  = request()->ip(); 
        if(isset(auth()->guard('candidate')->user()->id))
        {
            $user_id = auth()->guard('candidate')->user()->id;
            $delete = Recent_job_search::where(['user_id'=>$user_id,'ip'=>$ip])->delete();
        }
        else
        {
            $delete = Recent_job_search::where(['ip'=>$ip])->delete();
        }
        return redirect()->back()->with('success', 'Jobs have been cleared successfully .');
    }

    public function searchJobs()
    {
       $this->data['functional_area'] = FunctionalArea::where('status','active')->pluck('name','slug');
        return view('webApp.job.search_jobs',$this->data);
    }

    // listing searched jobs
    public function searched_job_listing()
    {
    	$data = request()->all();
        
    	if(empty($data['l']))
    	{  
    		return redirect()->back()->with('error_notify','Location can not be left blank');
    	}

         $this->data['functional_area'] = FunctionalArea::where('status','active')->pluck('name','slug');

         $this->data['params'] = $data;

         if(isset($data['l']) && !empty($data['l']))
         {  
            $slug = $data['l'];
            $this->data['param_location'] = WorldLocation::where(['slug'=>$slug,'status'=>'active'])->orderBy('id','desc')->first();
            if(!empty($this->data['param_location'])){
                $this->data['param_location'] =  $this->data['param_location']; 
            }
            else{
                $this->data['l'] = ucwords(str_replace('-', ' ', $data['l']));
            }
         }

         if(isset($data['k']) && !empty($data['k']))
         {
            $this->data['param_keyword'] = $this->find_searched_keyword_val($data['k']);
            if(!empty($this->data['param_keyword'])){
                $this->data['param_keyword'] =  $this->data['param_keyword']; 
            }
            else{
                $this->data['k'] = ucwords(str_replace('-', ' ', $data['k']));
            }
         }

        $this->data['max_referral_bonus_amt'] = Employer_jobs::has('company')->where(['status'=>'active'])->max('referral_bonus_amt'); 

        $this->data['salary_max'] = Employer_jobs::has('company')->where(['status'=>'active'])->max('salary_max'); 

        $obj_jobs = $this->filter_jobs();
        $this->data['jobs'] = $obj_jobs;

        $this->data['total_records'] = $obj_jobs->total();
        
        $this->data['record_from'] = (($obj_jobs->currentPage() - 1) * $obj_jobs->perPage() + 1);

        $this->data['record_to'] = ($obj_jobs->currentPage() * $obj_jobs->perPage());
        $this->data['record_to'] = $this->data['record_to'] > $obj_jobs->total() ? $obj_jobs->total() : $this->data['record_to'];

        if(request()->ajax())
        {
            return view('webApp.job.include.search_job_html',$this->data);    
        }

        $this->data['top_cities'] = $this->top_job_cities();

        $this->data['work_types'] = work_type::where('status','active')->orderBy('name')->pluck('name','slug');

        $this->data['designation'] = Designation::where('status','active')->orderBy('name')->pluck('name','slug');

        $skill_ids = $obj_jobs->pluck('skill_ids')->toArray();
        $skill_ids = implode(",",$skill_ids);
        $skill_ids = array_unique(explode(",",$skill_ids ));
        $this->data['skills'] = Skill::whereIn('id', $skill_ids)->where('status','active')->orderBy('name')->pluck('name','slug');

        $this->data['educations'] = Education::where('status','active')->orderBy('name')->pluck('name','slug');

        $this->data['industries'] = Industry::where('status','active')->orderBy('name')->pluck('name','slug');

        $this->data['top_job_companies'] = $this->top_job_companies();
    	
        $this->data['recent_searched'] = Recent_job_search::my_recent_searched();

        return view('webApp.job.search_listing',$this->data);
    }

    // filter jobs based on home page search
    private function filter_jobs()
    {   
        $data       = request()->all();

        $where      = ['status'=>'active'];
        $obj_jobs   = Employer_jobs::has('company')->orderBy('id','desc');
        

        // soty by
        if(isset($data['sort']) && !empty($data['sort']))  
        {
            $sort_by = $data['sort'];
            if($sort_by == 'referral-amount')
            {
                $obj_jobs = Employer_jobs::has('company')->orderBy('referral_bonus_amt','desc');
            }
        }    

        // search by keyword
        if(isset($data['k']) && !empty($data['k']))  
        {   
            // search in designation
            $slug = slug_url($data['k']);
            $designation_id = Designation::select('id')->where(['slug'=>$slug,'status'=>'active'])->orderBy('id','desc')->value('id');

            if($designation_id)
            {
                $where['position_id'] = $designation_id;
            }

            // search in skill table
            $skill_id = Skill::select('id')->where(['slug'=>$slug,'status'=>'active'])->orderBy('id','desc')->value('id');

            if($skill_id)
            {
                $obj_jobs->whereRaw('FIND_IN_SET(?,skill_ids)',$skill_id);
            }

            // search in company (employer_detail) table
            $company_id = EmployerDetail::select('id')->where(['slug'=>$slug,'status'=>'active'])->orderBy('id','desc')->value('id');
            
            if($company_id)
            {
                $where['company_id'] = $company_id;
            }

            if(!$designation_id && !$skill_id && !$company_id){
                $obj_jobs->where('summary', 'like', '%' .$slug. '%');
            }
        }



        // search by functional area
        if(isset($data['f']) && !empty($data['f']))  
        {       
            $data['f'] = [$data['f']];
            
            $sql_f_area = FunctionalArea::select('id')->whereIn('slug',$data['f'])->where('status','active')->orderBy('id','desc')->pluck('id');
            
            if($sql_f_area->count())
            {
                $f_area_ids = $sql_f_area->toarray();
                $ids_str    = implode('|', $f_area_ids);
                $obj_jobs->whereRaw('CONCAT(",", functional_area_ids, ",") REGEXP ",('.$ids_str.'),"'); 
            }
        }


        // search by location
        if(isset($data['l']) && !empty($data['l']))  
        {
            $slug = slug_url($data['l']);
            $obj_loc = WorldLocation::select('country_id','state_id','city_id')
                                    ->where(['slug'=>$slug,'status'=>'active'])
                                    ->orWhere('slug', 'like', '%' .$slug. '%')
                                    ->orderBy('id','desc')
                                    ->first();

           if(!empty($obj_loc)){
                if($obj_loc->city_id)
                {   
                    $city_id = $obj_loc->city_id;
                    $obj_jobs->whereRaw('FIND_IN_SET(?,city_ids)',$city_id);
                }
                else if($obj_loc->state_id)
                {   
                    $state_id = $obj_loc->state_id;
                    $obj_jobs->whereRaw('FIND_IN_SET(?,state_ids)',$state_id);
                }
                else
                {
                    $where['country_id'] = $obj_loc->country_id;
                }   
           }else{
                $obj_jobs->whereRaw('FIND_IN_SET(?,city_ids)',0);
           }  
        }

        // apply filters
        $obj_job = $this->apply_search_job_filters($obj_jobs);

        $obj_jobs->where($where);
        $job_data = $obj_jobs->paginate(50);

        return $job_data;
    }

    // apply left filters
    private function apply_search_job_filters($obj_job)
    {   
        $data = request()->all();

        // posted date
        if(isset($data['p-date']) && !empty($data['p-date']))
        {
            $str = $data['p-date'];
            $posted_date = '';
            switch ($str)
            {
                case 'last-1-day':
                    $posted_date = date('Y-m-d H:i:s',strtotime(GMT_DATE_TIME."-1 day"));
                    break;

                case 'last-3-days':
                    $posted_date = date('Y-m-d H:i:s',strtotime(GMT_DATE_TIME."-3 day"));
                    break;

                case 'last-7-days':
                    $posted_date = date('Y-m-d H:i:s',strtotime(GMT_DATE_TIME."-7 day"));
                    break;

                case 'last-15-days':
                    $posted_date = date('Y-m-d H:i:s',strtotime(GMT_DATE_TIME."-15 day"));
                    break; 

                case 'last-30-days':
                    $posted_date = date('Y-m-d H:i:s',strtotime(GMT_DATE_TIME."-30 day"));
                    break;
            }

            if($posted_date)
            {   
                $obj_job->where('created_at','>=',$posted_date);
            }
        }

        // work type
        if(isset($data['w-t']) && !empty($data['w-t']))
        {   
            $sql_w = work_type::whereIn('slug',$data['w-t'])->pluck('id');

            if($sql_w->count())
            {
                $wt_ids = $sql_w->toarray();
                $obj_job->whereIn('work_type_id',$wt_ids); // apply work type filter 
            }
        }

        // location/cities
        if(isset($data['c']) && !empty($data['c']))
        {
            $sql_city = City::whereIn('slug',$data['c'])->where(['status'=>'active'])->pluck('id');

            if($sql_city->count())
            {
                $city_ids = $sql_city->toarray();
                $ids_str    = implode('|', $city_ids);
                $obj_job->whereRaw('CONCAT(",", city_ids, ",") REGEXP ",('.$ids_str.'),"'); 
            }
        }

        // referral bonous
        if(isset($data['rb']) && !empty($data['rb']))
        {
            $rb_arr     = explode('-',$data['rb']);
            $from_val   = isset($rb_arr[0])?$rb_arr[0]:0;     
            $to_val     = isset($rb_arr[1])?$rb_arr[1]:0;

            $obj_job->where('referral_bonus_amt','>=',$from_val);
            $obj_job->where('referral_bonus_amt','<=',$to_val);
        }
        else
        {
            /*if(isset($this->data['max_referral_bonus_amt']) && $this->data['max_referral_bonus_amt'] > 0)
            {   
                $from_val   = 0;     
                $to_val     = $this->data['max_referral_bonus_amt'];

                $obj_job->whereNull('referral_bonus_amt');

                $obj_job->orWhere(function($query) use($to_val,$from_val){
                    $query->where('referral_bonus_amt','>=',$from_val);
                    $query->where('referral_bonus_amt','<=',$to_val);
                });
            }*/
        }

        // salay
        if(isset($data['sal']) && !empty($data['sal']))
        {
            $sal_arr     = explode('-',$data['sal']);
            $from_val   = isset($sal_arr[0])?$sal_arr[0]:0;     
            $to_val     = isset($sal_arr[1])?$sal_arr[1]:0;
            $obj_job->where('salary_min','>=',$from_val);
            $obj_job->where('salary_max','<=',$to_val); 
        }
        else
        {   
            if(isset($this->data['salary_max']) && $this->data['salary_max'] > 0)
            {
                $from_val   = 0;     
                $to_val     = $this->data['salary_max'];
                $obj_job->where('salary_min','>=',$from_val);
                $obj_job->where('salary_max','<=',$to_val);
            }
        }

        // Designation
        if(isset($data['dg']) && !empty($data['dg']))
        {
            $sql_dg = Designation::whereIn('slug',$data['dg'])->pluck('id');

            if($sql_dg->count())
            {
                $dg_ids = $sql_dg->toarray();
                $obj_job->whereIn('position_id',$dg_ids); // apply work type filter 
            }
        }

        // Experience
        if(isset($data['exp']) && !empty($data['exp']))
        {
            $exp_arr    = explode('-',$data['exp']);
            $from_val   = isset($exp_arr[0])?$exp_arr[0]:0;     
            $to_val     = isset($exp_arr[1])?$exp_arr[1]:0;
            $obj_job->where('experience_min','>=',$from_val);
            $obj_job->where('experience_max','<=',$to_val); 
        }
        else
        {   
            $from_val   = 0;     
            $to_val     = 30;
            $obj_job->where('experience_min','>=',$from_val);
            $obj_job->where('experience_max','<=',$to_val);
        }

        // skills
        if(isset($data['sk']) && !empty($data['sk']))
        {
            $sql_skill = Skill::whereIn('slug',$data['sk'])->pluck('id');

            if($sql_skill->count())
            {
                $skill_ids = $sql_skill->toarray();
                $ids_str    = implode('|', $skill_ids);
                $obj_job->whereRaw('CONCAT(",", skill_ids, ",") REGEXP ",('.$ids_str.'),"'); 
            }
        }

        // education
        if(isset($data['edu']) && !empty($data['edu']))
        {
            $sql_edu = Education::whereIn('slug',$data['edu'])->pluck('id');

            if($sql_edu->count())
            {
                $edu_ids    = $sql_edu->toarray();
                $ids_str    = implode('|', $edu_ids);

                $obj_job->whereRaw('CONCAT(",", education_ids, ",") REGEXP ",('.$ids_str.'),"'); 
            }
        }

        // industry
        if(isset($data['ind']) && !empty($data['ind']))
        {
            $sql_ind = Industry::whereIn('slug',$data['ind'])->pluck('id');

            if($sql_ind->count())
            {
                $ind_ids = $sql_ind->toarray();

                $obj_job->whereIn('industry_id',$ind_ids);
            }
        }

        // company 
        if(isset($data['emp']) && !empty($data['emp']))
        {
            $sql_comp = EmployerDetail::whereIn('slug',$data['emp'])->pluck('id');

            if($sql_comp->count())
            {
                $company_ids = $sql_comp->toarray();
                $ids_str    = implode('|', $company_ids);
                $obj_job->whereRaw('CONCAT(",", company_id, ",") REGEXP ",('.$ids_str.'),"'); 
            }
        }

        return $obj_job;
    }

    // find top most cities with there top jobs by country
    private function top_job_cities()
    {
        $data = request()->all();

        $cities = [];

        $country_id = WorldLocation::select('country_id')->where(['slug'=>$data['l'],'status'=>'active'])->orderBy('id','desc')->value('country_id');

        if($country_id)
        {
            $cities = City::where(['country_id'=>$country_id,'status'=>'active'])->orderBy('total_active_jobs','desc')->orderBy('name')->take(10)->pluck('name','slug')->toArray();
        }

        return $cities;
    }

    // find top most job's company
    private function top_job_companies()
    {   
        $params = request()->all();

        $city_ids  = $ind_ids = null;

        $country_id = WorldLocation::select('country_id')->where(['slug'=>$params['l'],'status'=>'active'])->orderBy('id','desc')->value('country_id');

        // cities
        if(isset($params['c']) && !empty($params['c']))
        {
            $sql_city = City::whereIn('slug',$params['c'])->where(['status'=>'active'])->pluck('id');

            if($sql_city->count())
            {
                $city_ids = $sql_city->toarray();
            }
        }

        // industry
        if(isset($params['ind']) && !empty($params['ind']))
        {
            $sql_ind = Industry::whereIn('slug',$params['ind'])->pluck('id');
            if($sql_ind->count())
            {
                $ind_ids = $sql_ind->toarray();
            }
        }

        return EmployerDetail::top_most_companies($country_id,$city_ids,$ind_ids);
    }

    // filter top searched company ajax
    public function ajax_top_company_filter()
    {
        $params = request()->all();

        $city_ids  = $ind_ids = null;

        $country_id = WorldLocation::select('country_id')->where(['slug'=>$params['l'],'status'=>'active'])->orderBy('id','desc')->value('country_id');

        // cities
        if(isset($params['c']) && !empty($params['c']))
        {
            $sql_city = City::whereIn('slug',$params['c'])->where(['status'=>'active'])->pluck('id');

            if($sql_city->count())
            {
                $city_ids = $sql_city->toarray();
            }
        }

        // industry
        if(isset($params['ind']) && !empty($params['ind']))
        {
            $sql_ind = Industry::whereIn('slug',$params['ind'])->pluck('id');

            if($sql_ind->count())
            {
                $ind_ids = $sql_ind->toarray();
            }
        }

        $this->data['top_job_companies'] = EmployerDetail::top_most_companies($country_id,$city_ids,$ind_ids);

        $this->data['params'] = $params;

        return view('webApp.job.include.top_filtered_company_html',$this->data);    
    }

    private function find_searched_keyword_val($keyword)
    {
        // search in designation
        $obj_designation = Designation::select('slug','name')->where(['slug'=>$keyword,'status'=>'active'])->orderBy('id','desc')->first();

        if($obj_designation)
        {
            return ['title'=>$obj_designation->name,'slug'=>$obj_designation->slug];
        }

        // search in skill
        $obj_skill = Skill::select('slug','name')->where(['slug'=>$keyword,'status'=>'active'])->orderBy('id','desc')->first();

        if($obj_skill)
        {
            return ['title'=>$obj_skill->name,'slug'=>$obj_skill->slug];
        }

        // search in company
        $obj_company = EmployerDetail::select('slug','company_name')->where(['slug'=>$keyword,'status'=>'active'])->orderBy('id','desc')->first();

        if($obj_company)
        {
            return ['slug'=>$obj_company->slug,'title'=>$obj_company->company_name];
        }
    }

    // keyword suggestaion
    public function job_search_keyword_suggestion()
    {
    	if(!request()->ajax())
        {
            abort(404);
        }

        $keyword = trim(request()->get('keyword'));

        $final_data = [];

        if((strlen($keyword)) < 2)
        {   
            die('[{"id":"","text":"No record found"}]');
        }

        // search in designation
        $obj_designation = Designation::select('slug','name as text')->where('name','like',"%$keyword%")->where(['status'=>'active'])->take(10)->get();

        if($obj_designation->count())
        {
            $final_data = array_merge($final_data,$obj_designation->toarray());
        }

        // search in skills
        $obj_skill = Skill::select('slug','name as text')->where('name','like',"%$keyword%")->where(['status'=>'active'])->take(10)->get();

        if($obj_skill->count())
        {
            $final_data = array_merge($final_data,$obj_skill->toarray());
        }

        // search in company
        $obj_company = EmployerDetail::select('slug','company_name as text')->where('company_name','like',"%$keyword%")->where(['status'=>'active'])->take(10)->get();

        if($obj_company->count())
        {
            $final_data = array_merge($final_data,$obj_company->toarray());
        } 

        if($final_data)
        {   
            $final_data = array_map("unserialize", array_unique(array_map("serialize", $final_data))); // for unique result based on value

            $response = json_encode($final_data);
        }
        else
        {
            $response = '[{"id":"","text":"No record found"}]';
        }
    
        echo $response;exit;
    }

    public function job_search_keywords()
    {
        if(!request()->ajax())
        {
            abort(404);
        }

        $keyword = trim(request()->get('term'));

        $final_data = [];


        // search in designation
        $obj_designation = Designation::select('slug','name as text')->where('name','like',"%$keyword%")->where(['status'=>'active'])->take(10)->get();

        if($obj_designation->count())
        {
            $final_data = array_merge($final_data,$obj_designation->toarray());
        }

        // search in skills
        $obj_skill = Skill::select('slug','name as text')->where('name','like',"%$keyword%")->where(['status'=>'active'])->take(10)->get();

        if($obj_skill->count())
        {
            $final_data = array_merge($final_data,$obj_skill->toarray());
        }

        // search in company
        $obj_company = EmployerDetail::select('slug','company_name as text')->where('company_name','like',"%$keyword%")->where(['status'=>'active'])->take(10)->get();

        if($obj_company->count())
        {
            $final_data = array_merge($final_data,$obj_company->toarray());
        } 

        if($final_data)
        {   
            $final_data = array_map("unserialize", array_unique(array_map("serialize", $final_data))); // for unique result based on value

            $response = $final_data;
            $data=[];
            foreach ($response as $value) {
                    $data[] = $value['text'];
            }
            return $data;  
        } 

    }

    // location suggestation
    public function job_search_location_suggestion()
    {
        $keyword = trim(request()->get('keyword'));

        $data = '[{"id":"","text":"No data found"}]';

        if(strlen($keyword) > 3)
        {
            $sql = WorldLocation::select('slug','location as text')->where('location','like',"$keyword%")->take(50)->get();

            if($sql->count())
            {   
                $data = $sql;
            }
            else
            {
                $data = '[{"id":"","text":"No data found"}]';
            }
        }
        echo $data;exit;
    }

    public function job_search_locations()
    {
        $keyword = trim(request()->get('term'));

        $sql = WorldLocation::select('slug','location as text')->where('location','like',"$keyword%")->take(50)->get();

        if($sql->count())
        {   
            $locations = $sql;
            $data=[];
            foreach ($locations as $value) {
                    $data[] = $value['text'];
            }
            return $data; 

        }
       
    }

    // job deatil
    public function job_detail($slug)
    {   
        $obj_job = Employer_jobs::where(['slug'=>$slug])->where('status','!=','pending')->firstOrFail();
        
        $ipAddress = getenv('REMOTE_ADDR');

        $checkIp = \DB::table('views_on_jobs')->where(['job_id'=>$obj_job->id,'ip'=>$ipAddress])->first();
        if(!$checkIp)
        {
            $insertIp = \DB::table('views_on_jobs')->insert(['job_id'=>$obj_job->id,'ip' => $ipAddress]);

            $totalViews = $obj_job->total_views+1;
            Employer_jobs::where('id',$obj_job->id)->update(['total_views'=>$totalViews]);

        }

        // location
        $country_id = $obj_job->country_id; 
        $location = WorldLocation::where(['country_id'=>$country_id,'status'=>'active'])->orderBy('id','desc')->whereNull(['state_id','city_id'])->value('slug');

        $this->data['similar_job_url'] = $this->similar_job_url($obj_job,$location);

        $this->data['company_job_url'] = $this->prepare_company_job_url($obj_job,$location);

        // check already applied
        if(auth()->guard('candidate')->user())
        {
            $canId = auth()->guard('candidate')->user()->id;
            $this->data['check_applied'] = Job_application::where(['job_id'=>$obj_job->id,'candidate_id'=>$canId])->first();

        }
        

        $this->data['obj_job'] = $obj_job;
        return view('webApp.job.job_detail',$this->data);
    }

    private function prepare_company_job_url($obj_job,$location)
    {   
        $company_job_url = route('web.job.search.listing')."?";
        
        if($location)
        {
            $company_job_url.='l='.$location.'&';
        }

        // company name slug
        if(isset($obj_job->company->slug))
        {
            $company_job_url.='k='.$obj_job->company->slug;
        }

        return $company_job_url;
    }


    // prepare company job url
    private function similar_job_url($obj_job,$location)
    {
        $company_job_url = route('web.job.search.listing')."?";
               
        if($location)
        {
            $company_job_url.='l='.$location;
        }

        // skills
        if(isset($obj_job->skill_ids))
        {
            $skill_ids = explode(',',$obj_job->skill_ids);
            $sql_skill = Skill::whereIn('id',$skill_ids)->pluck('slug');

            if($sql_skill->count())
            {
                $skill_arr['sk'] = $sql_skill->toarray();
                $company_job_url .= '&'.http_build_query($skill_arr);
            }
        }

        // functional area
        if(isset($obj_job->functional_area_ids))
        {   
            $f_area_ids = explode(',',$obj_job->functional_area_ids);

            $sql_f_area = FunctionalArea::whereIn('id',$f_area_ids)->pluck('slug');

            if($sql_f_area->count())
            {
                $f_area_arr['f'] = $sql_f_area->toarray();
                $company_job_url .= '&'.http_build_query($f_area_arr);
            }
        }

        // work type
        if(isset($obj_job->work_type_id))
        {
            $work_type_id = $obj_job->work_type_id;

            $slug = work_type::where('id',$work_type_id)->value('slug');

            if($slug)
            {
                $wt['w-t'] = [$slug];
                $company_job_url .= '&'.http_build_query($wt);
            }
        }

        return $company_job_url;
    }
}
