<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Specialist_jobs, Job_application};
use Auth;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $data;
    public function __construct()
    {
        // $users[] = Auth::user();
        // $users[] = Auth::guard()->user();
        // $users[] = Auth::guard('specialist')->user();
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

        $specialist_jobs = new Specialist_jobs();
        $job_applications = new Job_application(); 
        $specialist_company_name = @$my_detail->current_company->company_name??NULL;

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

        $this->data['accpted_jobs'] = $specialist_jobs
                            ->where(function($q) use($my_id){
                                    $q->where(function($query) use($my_id){
                                        $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                                    })->orWhere(function($query) use ($my_id){
                                        $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                                    });
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->whereRaw($where)
                            ->orderBy('id','desc')
                            ->count();


        $this->data['decline_jobs'] = $specialist_jobs
                                    ->where(function($q) use($my_id){
                                        $q->where(function($query) use($my_id){
                                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'decline');
                                        })->orWhere(function($query) use ($my_id){
                                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','decline');
                                        });
                                    })
                                    ->where(['is_current_specialist'=>'yes'])
                                    ->whereRaw($where)
                                    ->orderBy('id','desc')
                                    ->count();


        $this->data['active_jobs'] = $specialist_jobs
                            ->where(function($q) use($my_id){
                                    $q->where(function($query) use($my_id){
                                        $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                                    })->orWhere(function($query) use ($my_id){
                                        $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                                    });
                            })
                            ->whereHas('job', function( $query){
                                    $query->where('status', '=', 'active');
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->whereRaw($where)
                            ->orderBy('id','desc')
                            ->count();


        $this->data['on_hold_jobs'] = $specialist_jobs
                            ->where(function($q) use($my_id){
                                        $q->where(function($query) use($my_id){
                                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                                        })->orWhere(function($query) use ($my_id){
                                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                                        });
                                    })
                            ->whereHas('job', function( $query){
                                    $query->where('status', '=', 'on_hold');
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->whereRaw($where)
                            ->orderBy('id','desc')
                            ->count();                       

        //dd($this->data);
        $this->data['closed_jobs'] = $specialist_jobs
                            ->where(function($q) use($my_id){
                                        $q->where(function($query) use($my_id){
                                            $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                                        })->orWhere(function($query) use ($my_id){
                                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                                        });
                            })
                            ->whereHas('job', function( $query){
                                    $query->where('status', '=', 'closed');
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->whereRaw($where)
                            ->orderBy('id','desc')
                            ->count();


         $this->data['jobs_with_application'] = $specialist_jobs
                            ->where(function($q) use($my_id){
                                    $q->where(function($query) use($my_id){
                                        $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                                    })->orWhere(function($query) use ($my_id){
                                        $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                                    });
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->whereHas('job.getApplications')
                            ->whereRaw($where)
                            ->orderBy('id','desc')
                            ->count();                                          

        
        $this->data['jobs_with_successful_hires'] = $specialist_jobs
                            ->where(function($q) use($my_id){
                                    $q->where(function($query) use($my_id){
                                        $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                                    })->orWhere(function($query) use ($my_id){
                                        $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                                    });
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->whereHas('job.getApplications', function($query){
                                $query->where('status', 'hired');
                            })
                            ->whereRaw($where)
                            ->orderBy('id','desc')
                            ->count();

        $total_application  = $job_applications::whereHas('job', function($query) use($my_id){
                $query->whereHas('jobSpecialist', function($query) use($my_id){
                    $query->where(function($query) use($my_id){
                         $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'accept');
                        })->orWhere(function($query) use ($my_id){
                            $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','accept');
                        });
                    });
            });


        if($specialist_company_name)
        {
            $total_application = $total_application->whereDoesntHave('candidate.current_company', function($query) use($specialist_company_name){
                        //company_name
                        $query->where('company_name', $specialist_company_name); 
                    });
        }    

        $this->data['total_application_recevied'] =  $total_application->count(); 

        $this->data['applicatiom_rated_by_me'] = $job_applications->where('specialist_id', $my_id)->where('rating_by_specialist', '!=', NULL)->count();

        $this->data['application_shared_with_employer'] = $job_applications->where('specialist_id', $my_id)->count();

        $this->data['candidate_hired']= $job_applications->where('specialist_id', $my_id)->where('status', 'hired')->count();


        $this->data['new_jobs'] =   $specialist_jobs
                            ->where(function($q) use($my_id){
                                    $q->where(function($query) use($my_id){
                                        $query->where('primary_specialist_id',$my_id)->where('primary_specialist_status', 'pending');
                                    })->orWhere(function($query) use ($my_id){
                                        $query->where('secondary_specialist_id',$my_id)->where('secondary_specialist_status','pending');
                                    });
                            })
                            ->where(['is_current_specialist'=>'yes'])
                            ->orderBy('id','desc')
                            ->count(); 

        //dd($this->data['total_application_recevied']);
                       
        $this->data['active_menue'] = 'dashboard';
        return view('specialistApp.dashboard', $this->data);
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
