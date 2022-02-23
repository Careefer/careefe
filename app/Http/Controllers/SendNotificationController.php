<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\Specialist\JobApplicationStatusNotificationByEmployer;
use App\Notifications\Specialist\SpecialistNewsletterNotification;
use App\Notifications\Specialist\SpecialistPasswordChangeNotification;
use App\Notifications\Candidate\JobApplicationStatusNotification;
use App\Notifications\Candidate\CandidateNewsletterNotification;
use App\Notifications\Candidate\ApplyReferJobNotification;
use App\Notifications\Candidate\SpecialistAcceptJobNotification;
use App\Notifications\Specialist\CandidateApplyJobNotification;
use App\Notifications\Employer\EmployerNewsletterNotification;
use App\Notifications\Employer\ForwardJobApplicationNotification;
use App\Notifications\Employer\AssignSpecialistNotification;
use App\Notifications\Employer\PublishJobNotification;
use App\Notifications\Specialist\AdminAssignJobNotification;
use App\Models\UserNotificationSetting;
use App\Models\Employer_jobs;
use App\Models\Job_application;
use App\{Specialist};
use App\{Candidate};
use App\{Employer};

class SendNotificationController extends Controller
{
    public function jobStatusNotification($candidate_id,$application_status,$specialist_id,$application_id,$job_id)
    {
        // send to condidate
        $specialist = Specialist::where('id',$specialist_id)->first();
        $candidate = Candidate::where('id',$candidate_id)->first();
        $getData = [
            'first_name'    => $specialist->first_name,
            'last_name'     => $specialist->last_name,
            'notification'  => 'Your Job Application status is '.$application_status.' for Application ID : '.$application_id,
        ];
        if(check_notification_setting($candidate_id, 'APPLICATION_REFERRALS_PAYMENTS', 'candidate')){
        	$candidate->notify(new JobApplicationStatusNotification($getData)); 	
        }

        // send to employer
        $emp_jobs = Employer_jobs::where('id',$job_id)->first();
        $employer_id =  $emp_jobs->employer_id;
        $employer = Employer::where('id',$employer_id)->first();
        $getData = [
            'first_name'    => $specialist->first_name,
            'last_name'     => $specialist->last_name,
            'notification'  => 'has forwarded you Job Application for Application ID : '.$application_id.' with status '.$application_status,
        ];

        if(check_notification_setting($employer_id, 'NEW_APPLICATIONS', 'employer')){
            $employer->notify(new ForwardJobApplicationNotification($getData));     
        }

    }

    public function applyReferJobNotification($candidate_name,$refer_by,$job_id)
    {
         $candidate = Candidate::where('id',$refer_by)->first();
         $getData = [
             'first_name'    => $candidate_name,
             'last_name'     => '',
             'notification'  => 'has applied the following job '.$job_id.' referred by you.',
         ];
         if(check_notification_setting($refer_by, 'APPLICATION_REFERRALS_PAYMENTS', 'candidate')){
            $candidate->notify(new ApplyReferJobNotification($getData));  
         }
    }

    public function specialistAcceptJobNotification($job_id)
    {
        $job_application = Job_application::select('candidate_id')->where('job_id',$job_id)->get();
        foreach ($job_application as $key => $value) 
        {
             if(!empty($value->candidate_id))
             {
                     $candidate = Candidate::where('id',$value->candidate_id)->first();
                     $getData = [
                     'first_name'    => my_detail()->first_name,
                     'last_name'     => my_detail()->last_name,
                     'notification'  => 'has accepted the following job',
                 ];

                 if(check_notification_setting($value->candidate_id, 'APPLICATION_REFERRALS_PAYMENTS', 'candidate')){    
                  $candidate->notify(new SpecialistAcceptJobNotification($getData)); 
                 }
             }
        }
    }


    public function NewsletterNotification($user_type)
    {
    	if($user_type=='candidate')
    	{
	    	$candidates = Candidate::all();
	    	foreach ($candidates as  $candidate) 
	    	{
	    	      $candidate_id = $candidate->id;
	    	      $candidate = Candidate::where('id',$candidate_id)->first();
		      	  $getData = [
		              'first_name'    => 'Admin',
		              'last_name'     => '',
		              'notification'  => 'has sent you newsletter on your email',
		          ];
		          if(check_notification_setting($candidate_id, 'NEWSLETTERS_GENERAL_MESSAGES', 'candidate')){
		          	$candidate->notify(new CandidateNewsletterNotification($getData)); 	
		          }

	    	}	
    	}

    	elseif($user_type=='specialist')
    	{
			$specialists = Specialist::all();
          	foreach ($specialists as  $specialist) 
          	{
                  $specialist_id = $specialist->id;
	    	      $specialist = Specialist::where('id',$specialist_id)->first();
		      	  $getData = [
		              'first_name'    => 'Admin',
		              'last_name'     => '',
		              'notification'  => 'has sent you newsletter on your email',
		          ];
		        if(check_notification_setting($specialist_id, 'GENERAL_NEWSLETTER', 'specialist')){
		          	$specialist->notify(new SpecialistNewsletterNotification($getData)); 	
		          }
          	}

    	}

    	elseif($user_type=='employer')
    	{
    		$employers = Employer::all();
    		foreach ($employers as  $employer) 
    		{
			      $employer_id = $employer->id;
	    	      $employer = Employer::where('id',$employer_id)->first();
		      	  $getData = [
		              'first_name'    => 'Admin',
		              'last_name'     => '',
		              'notification'  => 'has sent you newsletter on your email',
		          ];
		        if(check_notification_setting($employer_id, 'GENERAL_NEWSLETTER', 'employer')){
		          	$employer->notify(new EmployerNewsletterNotification($getData)); 	
		          }  
    		}
    	}	
    }

    public function candidateApplyJobNotification($primary_specialist_id,$secondary_specialist_id,$candidate_name,$job_id)
    {
    	if(!empty($primary_specialist_id))
    	{
    		 $specialist = Specialist::where('id',$primary_specialist_id)->first();
    		 $getData = [
    		     'first_name'    => $candidate_name,
    		     'last_name'     => '',
    		     'notification'  => 'has applied for the following job'." ".$job_id,
    		 ];
    		 if(check_notification_setting($primary_specialist_id, 'NEW_APPLICATIONS', 'specialist')){
    		 	$specialist->notify(new CandidateApplyJobNotification($getData)); 	
    		 }
    	}

    	if(!empty($secondary_specialist_id))
    	{
    		 $specialist = Specialist::where('id',$secondary_specialist_id)->first();
    		 $getData = [
    		     'first_name'    => $candidate_name,
    		     'last_name'     => '',
    		     'notification'  => 'has applied for the following job'." ".$job_id,
    		 ];
    		 if(check_notification_setting($secondary_specialist_id, 'NEW_APPLICATIONS', 'specialist')){
    		 	$specialist->notify(new CandidateApplyJobNotification($getData)); 	
    		 }
    	}
    }

    public function adminAssignJobNotification($primary_specialist_id,$secondary_specialist_id,$job_id)
    {
    	if(!empty($primary_specialist_id))
    	{
    		 /*$obj_job = Employer_jobs::where(['job_id'=>$job_id,'primary_specialist_id'=>$primary_specialist_id])->first();*/
    		 
    		 $specialist = Specialist::where('id',$primary_specialist_id)->first();
    		 $getData = [
    		     'first_name'    => 'Admin',
    		     'last_name'     => '',
    		     'notification'  => 'has assigned the following job'." ".$job_id,
    		 ];
    		 if(check_notification_setting($primary_specialist_id, 'NEW_JOBS_ASSIGNED', 'specialist')){
    		 	$specialist->notify(new AdminAssignJobNotification($getData)); 	
    		 }
    	}

    	if(!empty($secondary_specialist_id))
    	{
    		 $specialist = Specialist::where('id',$secondary_specialist_id)->first();
    		 $getData = [
    		     'first_name'    => 'Admin',
    		     'last_name'     => '',
    		     'notification'  => 'has assigned the following job'." ".$job_id,
    		 ];
    		 if(check_notification_setting($secondary_specialist_id, 'NEW_JOBS_ASSIGNED', 'specialist')){
    		 	$specialist->notify(new AdminAssignJobNotification($getData)); 	
    		 }
    	}
    }

    public function jobStatusNotificationByEmployer($candidate_id,$specialist_id,$application_id,$application_status)
    {
        $candidate = Candidate::where('id',$candidate_id)->first();
        $getData = [
            'first_name'    => 'Employer',
            'last_name'     => '',
            'notification'  => 'Your Job Application status is '.$application_status.' for Application ID : '.$application_id,
        ];

        if(check_notification_setting($candidate_id, 'APPLICATION_REFERRALS_PAYMENTS', 'candidate'))
        {
            $candidate->notify(new JobApplicationStatusNotification($getData));     
        }

        $specialist = Specialist::where('id',$specialist_id)->first();

        $getData = [
            'first_name'    => 'Employer',
            'last_name'     => '',
            'notification'  => 'The Application status is '.$application_status.' for Application ID : '.$application_id,
        ];
        if(check_notification_setting($specialist_id, 'UPDATE_ON_JOBS_APPLICATION_STATUS', 'specialist'))
        {
            $specialist->notify(new JobApplicationStatusNotificationByEmployer($getData));     
        }
    }

    public function specialistPasswordChangeNotification()
    { 
        $specialist = my_detail();
        $specialist_id = $specialist->id;
        $getData = [
            'first_name'    => '',
            'last_name'     => '',
            'notification'  => 'You have changed your password successfully.',
        ];
        if(check_notification_setting($specialist_id, 'PASSWORD_CHANGE', 'specialist')){
            $specialist->notify(new SpecialistPasswordChangeNotification($getData));     
        }
    }

    public function adminAssignSpecialistNotification($employer_id,$job_id)
    {
        $employer = Employer::where('id',$employer_id)->first();
        $getData = [
            'first_name'    => 'Admin',
            'last_name'     => '',
            'notification'  => 'has assigned specialist on Job ID : '.$job_id,
        ];

        if(check_notification_setting($employer_id, 'JOB_PUBLISHED_SPECIALIST_ASSIGNED', 'employer')){
            $employer->notify(new AssignSpecialistNotification($getData));     
        }
    }

    public function adminpPublishJobNotification($employer_id,$job_id)
    {
        $employer = Employer::where('id',$employer_id)->first();
        $getData = [
            'first_name'    => 'Admin',
            'last_name'     => '',
            'notification'  => 'has published job. Job ID : '.$job_id,
        ];

        if(check_notification_setting($employer_id, 'JOB_PUBLISHED_SPECIALIST_ASSIGNED', 'employer')){
            $employer->notify(new PublishJobNotification($getData));     
        }
    }
}
