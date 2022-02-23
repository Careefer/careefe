<?php

namespace App\Http\Controllers\EmployerApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employer_jobs, Job_application};

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $data;
    protected $employer_jobs;
    protected $job_applications;

    public function __construct()
    {
        $this->employer_jobs = new Employer_jobs();
        $this->job_applications = new Job_application();
    }

    public function index()
    {
        $my_id = my_id(); 

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

        $type = request()->input('type') ?? '';
        $where = '';

        if($type == 'month')
        {
          $where = 'created_at >='.$first_day_this_month.' AND created_at <='. $last_day_this_month;   
        }elseif($type == 'week'){
            $where = 'created_at >='.$first_day_this_week.' AND created_at <='. $last_day_this_week;
        }elseif($type == 'today'){
            $where = 'created_at ='.$currentDay;
        }else{
            $where ='1=1';
        }  

        $employer_jobs = $this->employer_jobs->where('employer_id', $my_id)->whereRaw($where);

        $this->data['posted_jobs'] = $employer_jobs->whereNotIn('status', ['pending','rejected'])->count();

        $this->data['application_recevied'] =  $this->job_applications->whereHas('job', function($query) use($my_id){
                $query->where('employer_id', $my_id); 
            })->where('specialist_id', '!=', NULL)->whereRaw($where)->count(); 

        $this->data['job_with_application_recevied'] = $employer_jobs->whereNotIn('status', ['pending','rejected'])
            ->whereHas('getApplications')->count();
            
        $this->data['job_with_application_recevied_with_success_hired'] = $employer_jobs->whereNotIn('status', ['pending','rejected'])
            ->whereHas('getApplications', function($query){
                $query->where('status', 'hired');
            })->count();

        $this->data['candidate_hired'] =  $this->job_applications->whereHas('job', function($query) use($my_id){
                $query->where('employer_id', $my_id); 
            })->where('specialist_id', '!=', NULL)->where('status','hired')->whereRaw($where)->count();             

        $this->data['closed_jobs'] =  $employer_jobs->where('status', 'closed')->count();
        
        $this->data['open_jobs'] = $employer_jobs->where('status', 'active')->count();

        $this->data['on_hold_jobs'] = $employer_jobs->where('status', 'on_hold')->count();     

        //dd($this->data['job_with_application_recevied_with_success_hired']);

        $this->data['active_menue'] = 'dashboard';
        return view('employerApp.dashboard', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
