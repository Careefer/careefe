<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recent_job_search extends Model
{
    protected $table = 'recent_job_search';

    public $fillable = ['user_id','ip','string','location','total_result','slug'];

    // find my recent searched jobs
    public static function my_recent_searched()
    {
		$user_id = null;
        $ip = request()->ip();

        $obj = Recent_job_search::orderBy('updated_at','desc');
        $obj->where('ip',$ip);
        $obj->whereNotNull('string');

        if(isset(auth()->guard('candidate')->user()->id))
        {
            $user_id = auth()->guard('candidate')->user()->id;

            $obj->orWhere('user_id',$user_id);
        }

        $obj->take(5);
        $data = $obj->get();
        
        return $data;
    }
}
