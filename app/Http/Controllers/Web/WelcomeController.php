<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WelcomeController extends Controller
{   
    protected $data = [];
    /**
     * index 
     */
    public function home()
    {   
        // banner data
        $this->data['obj_banner'] = \App\Models\Banner::where(['status'=>'active','id'=>'1'])->first();
        $this->data['second_banner'] = \App\Models\Banner::where(['status'=>'active','id'=>'2'])->first();

        // featured employer
         $this->data['featured_employer'] = \App\Models\EmployerDetail::where(['is_featured'=>'yes'])->take(16)->get();   

         // our blog data
         $this->data['our_blog'] = \App\Models\Blog::has('category')->where(['status'=>'active'])->orderBy('id','desc')->take(12)->get();   

         // recent job
         $this->data['recent_jobs'] = \App\Models\Employer_jobs::take(10)->has('company')->where('status','active')->orderBy('id','desc')->get();

         // popular job
         $this->data['popular_jobs'] = \App\Models\Employer_jobs::take(10)->has('company')->where('status','active')->orderBy('total_views','desc')->get();

         // functional area
         $this->data['functional_area'] = \App\Models\FunctionalArea::where('status','active')->pluck('name','slug');

        $this->data['recent_searched'] = \App\Models\Recent_job_search::my_recent_searched();        

    	return view('webApp.home.index',$this->data);
    }

    /**
     * ajax location search
     */
    function ajax_location_suggestion()
    {       
        $keyword = trim(request()->get('keyword'));

        $data = '[{"id":"","text":"No data found"}]';
      
        if(strlen($keyword) >= 3)
        {
            $sql = \App\Models\WorldLocation::select('id','location as text')->where('location','like',"$keyword%")->whereNotNull(['city_id'])->take(50)->get();

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

    /**
     * ajax get states by country id
     */
    public function get_states($country_id = 0)
    {   
        $data = [];

        if(!$country_id)
        {
            $data = [['name'=>'Data not found','id'=>null]];
            return response($data, 200);
        }

        $data = \App\Models\State::where(['country_id'=>$country_id,'status'=>'active'])->orderBy('name')->select('name','id')->get();

        if($data->count())
        {
            return response($data, 200);   
        }
        else
        {   
            $data = [['name'=>'Data not found','id'=>null]];
            return response($data, 200);   
        }
    }

    /**
     * ajax get states by country id
     */
    public function get_cities($state_id)
    {   
        if(!$state_id)
        {
            $data = [['name'=>'Data not found','id'=>null]];
            return response($data, 200);
        }

        $data = \App\Models\City::where(['state_id'=>$state_id,'status'=>'active'])->orderBy('name')->select('name','id')->get();

        
        if($data->count())
        {
            return response($data, 200);   
        }
        else
        {   
            $data = [['name'=>'Data not found','id'=>null]];
            return response($data, 200);   
        }  
    }

    public function getCurrency($country_id = 0)
    {   
        $data = [];

        if(!$country_id)
        {
            $data = [['name'=>'Data not found','id'=>null]];
            return response($data, 200);
        }

        $data = \App\Models\Currency::where(['country_id'=>$country_id,'status'=>'active'])->select('name','symbol')->first();

        if($data)
        {
            return response($data, 200);   
        }
        else
        {   
            $data = [['name'=>'Data not found','id'=>null]];
            return response($data, 200);   
        }
    }

    public function currencyRateConversion(Request $request)
    {
        $post = $request->all();
        $toisoCode = $post['isoCode'];

        $request->session()->put('toIsoCode', $toisoCode);

        $currency = \App\Models\Currency::where(['iso_code'=>$toisoCode])->select('symbol')->first();
        if($currency){
            $currency  = $currency->symbol;
            $request->session()->put('symbol', $currency);
        }

        if($toisoCode=='none')
        {
            $request->session()->forget('toIsoCode');
            return response($toisoCode, 200);   
        }
        else
        {   
            return response($toisoCode, 200);      
        }

    }

    // not calling from any where yet it just a script
    private function update_world_locations()
    {   
        ini_set('max_execution_time', '60000');

        exit; 

        // update with city ,state,country
        $data = DB::table('world_cities AS A')
                    ->select('B.name as country_name','C.name AS state_name','A.name AS city_name','A.country_id','A.state_id','A.id as city_id','A.state_code','A.country_code','A.latitude','A.longitude')
                    ->leftJoin('world_countries AS B','A.country_id','=','B.id')
                    ->leftJoin('world_states AS C','A.state_id','=','C.id')
                    ->get();

        foreach ($data as $key => $obj)
        {   
            $insert_arr = [];

             $insert_arr['country_id'] = $obj->country_id;
             $insert_arr['state_id'] = $obj->state_id;
             $insert_arr['city_id'] = $obj->city_id;
             $insert_arr['state_code'] = $obj->state_code;
             $insert_arr['country_code'] = $obj->country_code;
             $insert_arr['latitude'] = $obj->latitude;
             $insert_arr['longitude'] = $obj->longitude;
             $insert_arr['location'] = $obj->city_name.', '.$obj->state_name.', '.$obj->country_name;
             $insert_arr['slug'] = slug_url($insert_arr['location']);
            
            //DB::table('world_location')->insert($insert_arr);
        }



        // update state,country with country
        $data = DB::table('world_states AS A')
                    ->select('A.name as state_name','B.name AS country_name','A.country_id','A.id AS state_id','A.iso2 as state_code','A.country_code')
                    ->leftJoin('world_countries AS B','A.country_id','=','B.id')
                    ->get();

        foreach ($data as $key => $obj)
        {   
            $insert_arr = [];

             $insert_arr['country_id']      = $obj->country_id;
             $insert_arr['state_id']        = $obj->state_id;
             $insert_arr['state_code']      = $obj->state_code;
             $insert_arr['country_code']    = $obj->country_code;
             $insert_arr['location']        = $obj->state_name.', '.$obj->country_name;
             $insert_arr['slug']            = slug_url($insert_arr['location']);
             $insert_arr['status']          = 'active';



            //DB::table('world_location')->insert($insert_arr);
        }

        // update country 
        $data = DB::table('world_countries')->get();

        foreach ($data as $key => $obj)
        {
            $insert_arr = [];

             $insert_arr['country_id']      = $obj->id;
             $insert_arr['country_code']      = $obj->iso2;
             $insert_arr['location']        = $obj->name;
             $insert_arr['slug']            = slug_url($insert_arr['location']);
             $insert_arr['status']          = 'active';

            //DB::table('world_location')->insert($insert_arr);

        }

        die('inserted');
    }
}
