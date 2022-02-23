<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\{Candidate, Specialist, Employer};
use App\Models\{Employer_jobs, Job_application, PaymentHistory};
use DB;
use Carbon\Carbon;


class DashboardController extends Controller
{   
    private $data;
    public function dashboard()
    {   
        //cache store timing
        $seconds = 7200;
        //required date find
        $currentDay = date('Y-m-d');
        $currentMonth = date('m');
        //curent month first and last day
        $first_day_this_month = date('Y-m-01'); 
        $last_day_this_month  = date('Y-m-t');
        //current week first and last date
        $ts = strtotime($currentDay);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last monday', $ts);
        $first_day_this_week = date('Y-m-d', $start);
        $last_day_this_week = date('Y-m-d', strtotime('next sunday', $start));
            
        // query with cache
        $candidates = \Cache::remember('candidates', $seconds, function ()            {
                            return DB::table('candidates')->get();
                        });

       $specialists  = \Cache::remember('specialists', $seconds, function (){
                            return DB::table('specialists')->get();
                        });

       $employers = \Cache::remember('employers', $seconds, function ()            {
                            return DB::table('employers')->get();
                        });

       $employer_jobs = \Cache::remember('employer_jobs', $seconds, function (){
                            return DB::table('employer_jobs')
                            ->leftjoin('job_applications', 'job_applications.job_id', '=', 'employer_jobs.id')
                            ->select('employer_jobs.*','job_applications.application_id', 'job_applications.status as application_status')
                            ->get();
                        });

       $job_applications = \Cache::remember('job_applications', $seconds, function ()            {
                            return DB::table('job_applications')->get();
                        });

       $payment_history = \Cache::remember('payment_history', $seconds, function(){
                            return DB::table('payment_history')->get();
                        });


        if(request()->get('f')) // download file
        {
            return $this->download_file(request()->get('f'));
        }


        if(request()->get('type'))
        {   $dta = request()->get('type');
            if($dta == 'today'){
                $candidates = $candidates->where('created_at', $currentDay);

                $specialists = $specialists->where('created_at', $currentDay);

                $employers = $employers->where('created_at', $currentDay);

                $employer_jobs = $employer_jobs->where('created_at', $currentDay);

                $payment_history = $payment_history->where('created_at', $currentDay);
                $job_applications = $job_applications->where('created_at', $currentDay);    

            }elseif($dta == 'week')
            {
                $candidates = $candidates->whereBetween('created_at', [$first_day_this_week, $last_day_this_week]);
                
                $specialists = $specialists->whereBetween('created_at', [$first_day_this_week, $last_day_this_week]);

                $employers = $employers->whereBetween('created_at', [$first_day_this_week, $last_day_this_week]);

                $employer_jobs = $employer_jobs->whereBetween('created_at', [$first_day_this_week, $last_day_this_week]);

                $payment_history = $payment_history->whereBetween('created_at', [$first_day_this_week, $last_day_this_week]);

                $job_applications = $job_applications->whereBetween('created_at', [$first_day_this_week, $last_day_this_week]);

            }elseif($dta == 'month')
            {
                $candidates = $candidates->whereBetween('created_at', [$first_day_this_month, $last_day_this_month]);
                
                $specialists = $specialists->whereBetween('created_at', [$first_day_this_month, $last_day_this_month]);

                $employers = $employers->whereBetween('created_at', [$first_day_this_month, $last_day_this_month]);

                $employer_jobs = $employer_jobs->whereBetween('created_at', [$first_day_this_month, $last_day_this_month]);

                $payment_history = $payment_history->whereBetween('created_at', [$first_day_this_month, $last_day_this_month]);

                $job_applications = $job_applications->whereBetween('created_at', [$first_day_this_month, $last_day_this_month]);
            }
        }


        $this->data['total_candidate'] = $candidates->count();    

        $this->data['total_specialist'] = $specialists->count();

        $this->data['total_employer'] = $employers->count();

        $this->data['total_users'] = $this->data['total_candidate'] + $this->data['total_specialist'] +  $this->data['total_employer'];

        $this->data['total_jobs'] = $employer_jobs->groupBy('job_id')->count();

        $this->data['total_applications'] = $job_applications->count();

        $this->data['hired_applications'] = $job_applications->where('status','=','hired')->count();

        $this->data['successful_applications'] = $job_applications->where('status','=','success')->count();

        $this->data['total_referrals'] = $job_applications->where('refer_by','!=', NULL)->count();

        $this->data['due_payment_specialist_applictions'] = $payment_history->where('user_type','=' ,'specialist')->where('is_paid','=',0)->count();

        $this->data['due_payment_referee_applictions'] = $payment_history->whereIn('user_type', ['candidate', 'referre-specialist'])->where('is_paid','=',0)->count();

        // function($query){
        //                         $query->where('user_type','=' ,'candidate')->orwhere('user_type','=' ,'referre-specialist');
                            // })

        $this->data['due_payment_from_employer_applictions'] =  $payment_history->where('user_type','=' ,'admin')->where('is_paid','=',0)->count();

        $this->data['employer_posted_jobs'] = $employer_jobs->groupBy('employer_id')->count();

        $this->data['unpublish_jobs'] = $employer_jobs->where('status', 'pending')->groupBy('job_id')->count();                   

        $this->data['unassign_jobs'] = $employer_jobs->where('primary_specialist_id','=', NULL)->groupBy('job_id')->count();

        $this->data['total_open_jobs'] = $employer_jobs->where('status', 'active')->groupBy('job_id')->count();

        $this->data['job_with_no_application'] = $employer_jobs->where('application_id', NULL)->groupBy('job_id')->count();
        //->whereDoesntHave('getApplications')
        $this->data['successful_hire_jobs'] =  $employer_jobs->where('application_status', 'hired')->groupBy('job_id')->count();


        // whereHas('getApplications', function($query){
        //            $query->where('status', 'hired');
        //            })
        //         ->count();
        $this->data['active_menue'] = 'dashboard';
        return view('dashboard.dashboard', $this->data);
    }

    public function change_status(Request $req)
    {
        if($req->all())
        {
            $table          =   $req->get('db_table');
            $column         =   $req->get('column');
            $column_value   =   $req->get('column_value');
            $status         =   $req->get('status');
            $status         =   ($status == 'active') ? 'inactive' : 'active';

            $status = DB::table("$table")
                        ->where($column,$column_value)
                        ->update(['status'=>$status]);
                        
            if($status == true)
            {
                die(json_encode(['success'=>true,'msg'=>'Status changed successfully']));
            }   
            else
            {
                die(json_encode(['success'=>false,'msg'=>'Status not changed.']));
            }                     
        }
        else
        {
            die(json_encode(['success'=>false,'msg'=>'Error something went wrong.']));
        }
    }

    // download file
    public function download_file($file_path)
    {   
        $path = base64_decode($file_path);
        $path_arr = explode("/", $path);
        $file_name = end($path_arr);
        

        if(!file_exists($path) || !$file_name)
        {
            abort(404);
        }

        return response()->download($path, $file_name);
    }
}
