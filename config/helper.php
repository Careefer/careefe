<?php

use Illuminate\Support\Facades\Auth;
use App\Menu_model AS Menue_model;

use Illuminate\Support\Facades\Request;


function cmsPages()
{
    return $pages = \App\Models\Cms::whereIn('slug',['privacy-policy','terms-conditions','cookie-policy'])->get();
}

function cmsPage($page)
{
    return $pages = \App\Models\Cms::where(['slug'=>$page])->value('content');
}

function site_config($name)
{
    return \App\Models\Setting::where('name',$name)->value('value');
}

function display_price($price)
{
    return '$'.number_format($price,2);
}

function slug_url($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function left_menue()
{
    $user_detail    = Auth::user();
    $my_permissions = $user_detail->getAllPermissions();
    $menue_ids = [];
    if($my_permissions)
    {
        foreach($my_permissions AS $key => $value)
        {   
            if(!in_array($value->menue_id,$menue_ids))
            {
                $menue_ids[] = $value->menue_id;
            }
        }
    }

    $parent_ids = [];

    // get parents menues name who have parent = 0
    $p_menues_data = Menue_model::whereIn('id',$menue_ids)->where(['parent'=>'0'])->orderBy('sort','asc')->get();


    if(count($p_menues_data) > 0)
    {
        foreach ($p_menues_data as $key => $value)
        {   
            $parent_ids[$value->id] = ['id'=>$value->id,'name'=>$value->name,'class'=>$value->class,'id'=>$value->id,'url'=>$value->url,'permission_name'=>$value->permission_name];
        }
    }

    // get parents menues name who does not have parent = 0

    $temp_data = Menue_model::select('parent')->whereIn('id',$menue_ids)->where('parent','!=','0')->groupBy('parent')->get();

    if(count($temp_data) > 0)
    {
        foreach ($temp_data as  $temp)
        {
            $p_rest_menues_data = Menue_model::where(['parent'=>'0','id'=>$temp->parent])->first();

            $parent_ids[$p_rest_menues_data->id] = ['id'=>$p_rest_menues_data->id,'name'=>$p_rest_menues_data->name,'class'=>$p_rest_menues_data->class,'url'=>$p_rest_menues_data->url,'permission_name'=>$p_rest_menues_data->permission_name];
        }
    }

    // select sub category

    if(count($parent_ids) > 0)
    {
        foreach($parent_ids as $p_m_data)
        {
            $sub_menue_data = Menue_model::orderBy('sort','asc')->whereIn('id',$menue_ids)->where(['parent'=>$p_m_data['id']])->get();

            $temp = [];

            if(count($sub_menue_data) > 0)
            {
                foreach ($sub_menue_data as $skey => $svalue)
                {
                    $temp[$svalue->id] = ['id'=>$svalue->id,'name'=>$svalue->name,'class'=>$svalue->class,'url'=>$svalue->url,'permission_name'=>$svalue->permission_name];
                }
            }
            $parent_ids[$p_m_data['id']]['sub_menue'] = $temp;
        }
    }

    return $parent_ids;
}

function display_date_time($data)
{
    return date('d/m/Y h:i A',strtotime($data));
}

function displayMessagedate($data)
{
    return date('d',strtotime($data))." ".date('M',strtotime($data))." , ".date('Y',strtotime($data))." , ";
}

function displayTime($data)
{
    return date('h:i A',strtotime($data));
}

function messageDetailDateTime($data)
{
    return date('d',strtotime($data))." ".date('M',strtotime($data))." ".date('Y',strtotime($data))." , ".date('h:i A',strtotime($data));
}



function dateFormat($data)
{
    return date('Y-m-d',strtotime($data));
}

function displayDateFormat($data)
{
    return date('m/d/Y',strtotime($data));
}

function display_date($data)
{
    return date('d/m/Y',strtotime($data));
}

function get_date_db_format($date)
{   
    $system_date_format = 'dd/mm/yyyy';

    $db_fromat_date     = null;

    switch ($system_date_format)
    {
        case 'yyyy/mm/dd':
        $db_fromat_date = date('Y-m-d',strtotime(str_replace('/', '-', $date)));
        break;

        case 'mm/dd/yyyy':
        $db_fromat_date = date('Y-m-d',strtotime($date));
        break;

        case 'mm-dd-yyyy':
        $db_fromat_date = date('Y-m-d',strtotime(str_replace('-', '/', $date)));
        break;

        case 'dd/mm/yyyy':
        $db_fromat_date = date('Y-m-d',strtotime(str_replace('/', '-', $date)));
        break;

        case 'dd-mm-yyyy':
        $db_fromat_date = date('Y-m-d',strtotime($date));
        break;

        default:
        $db_fromat_date = date('Y-m-d',strtotime($date));
        break;
    }

    return $db_fromat_date;
}


function time_Ago($time)
{ 
    $time = strtotime($time);
    // Calculate difference between current 
    // time and given timestamp in seconds 
    $diff    = time() - $time;

    $str = ''; 
    
    // Time difference in seconds 
    $sec     = $diff; 
    
    // Convert time difference in minutes 
    $min     = round($diff / 60 ); 
    
    // Convert time difference in hours 
    $hrs     = round($diff / 3600); 
    
    // Convert time difference in days 
    $days    = round($diff / 86400 ); 
    
    // Convert time difference in weeks 
    $weeks   = round($diff / 604800); 
    
    // Convert time difference in months 
    $mnths   = round($diff / 2600640 ); 
    
    // Convert time difference in years 
    $yrs     = round($diff / 31207680 ); 
    
    // Check for seconds 
    if($sec <= 60) { 
        $str = "$sec seconds ago"; 
    } 
    
    // Check for minutes 
    else if($min <= 60) { 
        if($min==1) { 
            $str = "one minute ago"; 
        } 
        else { 
            $str = "$min minutes ago"; 
        } 
    } 
    
    // Check for hours 
    else if($hrs <= 24) { 
        if($hrs == 1) { 
            $str = "an hour ago"; 
        } 
        else { 
            $str = "$hrs hours ago"; 
        } 
    } 
    
    // Check for days 
    else if($days <= 7) { 
        if($days == 1) { 
            $str = "Yesterday"; 
        } 
        else { 
            $str = "$days days ago"; 
        } 
    } 
    
    // Check for weeks 
    else if($weeks <= 4.3) { 
        if($weeks == 1) { 
            $str = "a week ago"; 
        } 
        else { 
            $str = "$weeks weeks ago"; 
        } 
    } 
    
    // Check for months 
    else if($mnths <= 12) { 
        if($mnths == 1) { 
            $str = "a month ago"; 
        } 
        else { 
            $str = "$mnths months ago"; 
        } 
    } 
    
    // Check for years 
    else { 
        if($yrs == 1) { 
            $str = "one year ago"; 
        } 
        else { 
            $str = "$yrs years ago"; 
        } 
    }
    return $str; 
}

function is_favorite_job($candidate_id,$job_id)
{
    $obj = \App\Models\UserFavoriteJob::where(['candidate_id'=>$candidate_id,'job_id'=>$job_id])->get();

    return ($obj->count()) ? true:false;
}

function my_id()
{   
    $id = false;

    $arr = explode('_',auth()->guard()->getName());

    if(in_array('specialist',$arr) && auth()->guard('specialist')->check())
    {
        $id = auth()->guard('specialist')->user()->id;
    }

    if(in_array('candidate',$arr) && auth()->guard('candidate')->check())
    {
        $id = auth()->guard('candidate')->user()->id;
    }

    if(in_array('employer',$arr) && auth()->guard('employer')->check())
    {
        $id = auth()->guard('employer')->user()->id;
    }

    return $id;
} 

function my_detail()
{   
    $obj = false;

    $arr = explode('_',auth()->guard()->getName());

    if(in_array('specialist',$arr) && auth()->guard('specialist')->check())
    {
        $obj = auth()->guard('specialist')->user();
    }
    
    if(in_array('candidate',$arr) && auth()->guard('candidate')->check())
    {
        $obj = auth()->guard('candidate')->user();
    }
    
    if(in_array('employer',$arr) && auth()->guard('employer')->check())
    {
        $obj = auth()->guard('employer')->user();
    }

    return $obj;
}


function success_msg()
{   
    $html = '';
    if(session('success'))
    {
        $html = '<div class="form-msg">
            <p class="success_msg">
                '.session('success').'
            </p>
        </div>';
    }
    return $html; 
}

function randomPassword($len = 8)
{
    //enforce min length 8
    if($len < 8)
        $len = 8;

    //define character libraries - remove ambiguous characters like iIl|1 0oO
    $sets = array();
    $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    $sets[] = '23456789';
    //$sets[]  = '~!@#$%^&*(){}[],./?';

    $password = '';
    
    //append a character from each set - gets first 4 characters
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
    }

    //use all characters to fill up to $len
    while(strlen($password) < $len) {
        //get a random set
        $randomSet = $sets[array_rand($sets)];
        
        //add a random char from the random set
        $password .= $randomSet[array_rand(str_split($randomSet))]; 
    }
    
    //shuffle the password string before returning!
    return str_shuffle($password);
}

function display_rating($rating)
{   
    $total_rating = 5;
    $html  = '<ul class="admin-rating">';      

    foreach (range(1,$total_rating) as $value)
    {
        if($rating >=$value)
        {
            $html .='<li><img src="'.asset('assets/web/images/rating.png').'"></li>';    
        }
        else
        {
            $html .='<li><img src="'.asset('assets/web/images/rating-star2.png').'"></li>';        
        }   
    }
    $html .= '</ul>';
    return $html;
}

// currency converter amount
function get_amount($amt)
{   
    return '$'.$amt;
}

function record_not_found_msg()
{
    $html =  '<div class="not-record-listed">
                <h4 class="color-red">No records found !!</h4>
            </div>';  
    return $html;            
}

function check_notification_setting($user_id, $notification_setting, $user_type)
{
    $notification_setting_id = \App\Models\NotificationSetting::where(['name_key'=>$notification_setting,'user_type'=>$user_type])->first();
    $obj = \App\Models\UserNotificationSetting::where(['user_id'=>$user_id,'notification_setting_id'=>$notification_setting_id->id, 'status' => '1'])->first();

    return $obj ? true : false;
}

// get job status accordingly
function get_job_status($job_status)
{   
    $list = JOB_STATUS;

    switch($job_status)
    {
        case 'pending':
            unset($list['cancelled']);
            unset($list['on_hold']);
            unset($list['closed']);
        break;

        case 'active':
            unset($list['pending']);
            unset($list['rejected']);
        break;

        case 'on_hold':
            unset($list['pending']);
            unset($list['closed']);
            unset($list['rejected']);
        break;

        case 'cancelled':
            unset($list['pending']);
            unset($list['closed']);
            unset($list['on_hold']);
            unset($list['active']);
            unset($list['rejected']);
        break;

        case 'closed':
            unset($list['pending']);
            unset($list['cancelled']);
            unset($list['on_hold']);
            unset($list['active']);
            unset($list['rejected']);
        break;

        default:
            unset($list['closed']);
            unset($list['cancelled']);
            unset($list['rejected']);
        break;
    }

    return $list;
}

function save_job_status_log($job_id,$status,$action_by,$action_by_id)
{       
    $insert_arr['job_id'] = $job_id;
    $insert_arr['status'] = $status;
    $insert_arr['action_by'] = $action_by;
    $insert_arr['action_by_id'] = $action_by_id;
    $insert_arr['created_at'] = GMT_DATE_TIME;

    DB::table('job_change_status')->insert($insert_arr);
}

function currencies()
{
    $obj =  \App\Models\Currency::where(['status'=>'active'])->select('name','iso_code','symbol')->get();

    return  $obj;
}

function userCurrentLocation()
{

    $ip = \Request::ip();
    

    //$ip = '49.14.150.69';
    //$ip = '66.102.0.0';
    $userCurrentLocation = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    try {
        if($userCurrentLocation)
        {
            $toisoCode = $userCurrentLocation->geoplugin_currencyCode;
            request()->session()->put('toIsoCode', $toisoCode);

            $currency = \App\Models\Currency::where(['iso_code'=>$toisoCode])->select('symbol')->first();
            if($currency){
                $currency  = $currency->symbol;
                request()->session()->put('symbol', $currency);
            }
        }
        else
        {
            $toisoCode = "USD";
            request()->session()->put('toIsoCode', $toisoCode);

            $currency = \App\Models\Currency::where(['iso_code'=>$toisoCode])->select('symbol')->first();
            if($currency){
                $currency  = $currency->symbol;
                request()->session()->put('symbol', $currency);
            }
        }
    } catch (Excetption $e) {
            $toisoCode = "USD";
            request()->session()->put('toIsoCode', $toisoCode);

            $currency = \App\Models\Currency::where(['iso_code'=>$toisoCode])->select('symbol')->first();
            if($currency){
                $currency  = $currency->symbol;
                request()->session()->put('symbol', $currency);
            }
    }

    
            
    
}

function currencyRateConversion($fromIsoCode,$fromCurrencySign,$referral_bonus_amt)
{
        $toIsoCode = request()->session()->get('toIsoCode');
        $toCurrency = request()->session()->get('symbol');
        //dd($toIsoCode);

        
        $data = \App\Models\CurrencyConversion::where(['iso_code'=>$fromIsoCode])->select('conversion_rate')->first();
        if($data)
        {
            $data = json_decode($data->conversion_rate);
            //dd($data);
            if(!empty($data->$toIsoCode)){
                return $toCurrency.number_format($data->$toIsoCode*$referral_bonus_amt);
            }
            
        }
        return $fromCurrencySign.number_format($referral_bonus_amt);
}

 function getIp(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
    return request()->ip(); // it will return server ip when no client ip found
 }

?>