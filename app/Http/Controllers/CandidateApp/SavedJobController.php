<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{UserFavoriteJob, Job_application};

class SavedJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $viewBasePath;
    protected $data;
    protected $job_application;

    public function  __construct()
    {
        $this->viewBasePath = 'candidateApp.saved-job';
        $this->job_application = new Job_application();
    }

    public function index($type)
    {
        $this->data['job_type'] = $type;

        switch ($type)
        {
            case 'saved':
                $this->data['jobs'] =  $this->saved_jobs();
                break;
            case 'applied':
                $this->data['jobs'] = $this->applied_jobs();
                break;
            case 'approve':
                $this->data['jobs'] = $this->approved_jobs();
                break;        
            default:
                $this->data['jobs'] = [];
                break;                   
        }

        if(request()->ajax())
        {
            return view('candidateApp.saved-job.include.list_job_card_html',$this->data);
        }

        return view($this->viewBasePath.'.list', $this->data);
    }

    protected function saved_jobs()
    {
        $my_id = my_id();

        $data = UserFavoriteJob::orderBy('id','desc')->where('candidate_id', $my_id)
               ->with(['job.getApplications'=>function($query)
                {
                    $query->select('*', \DB::raw('(CASE 
                        WHEN status = "applied" THEN "Applied"
                        WHEN status = "in_progress_with_employer" THEN "In Progress with Employer"
                        WHEN status = "in_progress" THEN "In Progress with Specialist"
                        WHEN status = "success" THEN "Success"
                        WHEN status = "unsuccess" THEN "Unsuccess"
                        WHEN status = "hired" THEN "Hired"
                        WHEN status = "candidate_declined" THEN "Candidate declined"
                        WHEN status = "cancelled" THEN "Cancelled" 
                        END) AS status'));
                }])
                ->paginate(50);

        return $data;
    }

    protected function applied_jobs()
    {   
        $my_id = my_id();

        $data = Job_application::orderBy('id','desc')->where('applied_by', $my_id)
                      ->select('*', \DB::raw('(CASE 
                        WHEN status = "applied" THEN "Applied"
                        WHEN status = "in_progress_with_employer" THEN "In Progress with Employer"
                        WHEN status = "in_progress" THEN "In Progress with Specialist"
                        WHEN status = "success" THEN "Success"
                        WHEN status = "unsuccess" THEN "Unsuccess"
                        WHEN status = "hired" THEN "Hired"
                        WHEN status = "candidate_declined" THEN "Candidate declined"
                        WHEN status = "cancelled" THEN "Cancelled" 
                        END) AS status'))
                      ->paginate(50);

        return $data;
    }
    
    protected function approved_jobs()
    {
        $data = $this->job_application->approved_jobs();
        return $data;
    }
}
