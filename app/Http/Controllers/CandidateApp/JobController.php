<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserFavoriteJob;
use App\Models\Employer_jobs;
use App\Models\Refer_job_log;
use App\Models\Job_application;
use App\Candidate;
use App\Specialist;
use App\Http\Controllers\SendNotificationController;
use Validator;
use Mail;


class JobController extends Controller
{   
    private $data = [];

    // candidate make job favorite
    public function make_job_favorite()
    {
        $post = request()->all();
        if(empty($post['candidate_id']))
        {
        	return response()->json(['status'=>'failed','msg'=>'Candiate id is required'],200);
        }

        if(empty($post['job_id']))
        {
        	return response()->json(['status'=>'failed','msg'=>'Job id is required'],200);
        }

        $candidate_id = base64_decode($post['candidate_id']);
        $job_id = base64_decode($post['job_id']);
        $arr = ['candidate_id'=>$candidate_id,'job_id'=>$job_id];

		$obj_job = UserFavoriteJob::where($arr)->get();

		if($obj_job->count())
		{
			$obj = UserFavoriteJob::where($arr)->delete();

			$image = asset('assets/web/images/save-star2.png');

			return response()->json(['status'=>'success','type'=>'removed','msg'=>'Job removed from favorite list.','image'=>$image]);
		}
		else
		{
        	$obj = UserFavoriteJob::create($arr);

			$image = asset('assets/web/images/save-star.png');
        	
        	return response()->json(['status'=>'success','type'=>'added','msg'=>'Job added to favorite list.','image'=>$image]);
		}
    }

    // refer job to friend's email
    public function job_refer_to_email()
    {   
        request()->validate([
            'name'  => 'required',
            'friend_email' => 'required|email',
        ],
        [
            'friend_email.required' =>'The email field is required',
            'friend_email.email' =>'The email must be valid email address',
        ]);

        $job_id = request()->get('job_id');
        $my_id = my_id();

        $obj_job = Employer_jobs::where('id',$job_id)->firstOrFail();

        $url = route('web.job_detail',[$obj_job->slug]);
        $url .='?ref='.base64_encode($my_id);
        
        // save log
        $arr = [
            'refer_by_id'   => $my_id,
            'job_id'        => request()->get('job_id'),
            'friend_email'  => request()->get('friend_email'),
            'job_url'       => $url
        ];
        
        $obj = Refer_job_log::where($arr)->first();
        if($obj)
        {   
            $obj->updated_at = GMT_DATE_TIME;
            $obj->save();
        }
        else
        {
            Refer_job_log::create($arr); // create new        
        }

        // $mail_data['replacement'] = [
        //     'RECEIVER_NAME' => request()->get('name'),
        //     'SENDER_NAME' => auth()->guard('candidate')->user()->name,
        //     'JOB_URL' => $url,
        // ];

        $maildata['RECEIVER_NAME'] = request()->get('name');
        $maildata['SENDER_NAME']   = auth()->guard('candidate')->user()->name;
        $maildata['JOB_URL']       = $url;

        $toEmail = request()->get('friend_email');

        Mail::send('emails.job_reffer', ["maildata" => $maildata],function($message) use ($toEmail) {
            $message->to($toEmail)->subject('Job Reffered');
            //$message->from('no-reply@ldemedicalrecord.com','admin');
        }); 

        //dispatch(new \App\Jobs\JobReferByEmail($mail_data));

        return back()->with('success','Mail sent successfully.');
    }

    // apply on job
    public function view_apply_job_form($job_slug)
    {   
        $this->data['obj_job'] = Employer_jobs::where(['slug'=>$job_slug,'status'=>'active'])->firstOrFail();

        return view('candidateApp.job.apply_job',$this->data);
    }

    // apply job ajax form
    public function apply_job($job_slug)
    {   
        $post   = request()->all();

        if(!request()->ajax())
        {
            abort(404);
        }
        
        $obj_job = Employer_jobs::where('slug',$job_slug)->first();

        $specilist_companies = ($obj_job->specialist->career_history) ? $obj_job->specialist->career_history->pluck('company_name')->toArray() : []; 

        if(!$obj_job)
        {
            return response()->json(['status'=>'failed','msg'=>'Unable to find job id']);
        }

        // check already applied
        if(auth()->guard('candidate')->user())
        {
            $canId = auth()->guard('candidate')->user()->id;
            $check_applied = Job_application::where(['job_id'=>$obj_job->id,'candidate_id'=>$canId])->first();
            if($check_applied)
            {
                request()->session()->flash('success','You have already applied.');
                return response()->json(['status'=>'failed','msg'=>'You have already applied.']);
            }
        }

        $resp = $this->validate_job_form();

        if($resp)
        {
            return $resp;
        }

        $insert_arr = ['job_id'=>$obj_job->id,'applied_by'=>my_id()];
        $insert_arr['candidate_id'] = my_id();

        if(isset($post['ref']) && !empty($post['ref']))
        {   
            $refer_by = base64_decode($post['ref']);
            
            if($refer_by > 0)
            {   
                $insert_arr['refer_by'] = $refer_by;
            }
        }

        $insert_arr['name']     = $post['name'];
        $insert_arr['email']    = $post['email'];
        $insert_arr['mobile']   = $post['mobile'];

        $insert_arr['current_company']  = $post['current_company'];
        $insert_arr['application_id']   = Job_application::getNextApplicationId(); 
        
        $is_exist   = Job_application::where($insert_arr)->first();
        $arr        = $this->upload_new_cv_cover_letter();
        $insert_arr = array_merge($insert_arr,$arr);


        if($is_exist) // already applied
        {
            $is_exist->updated_at = GMT_DATE_TIME;
            $is_exist->save();
            $obj_application = $is_exist;
        }
        else
        {   
            $obj_application = Job_application::create($insert_arr);

            if(isset($post['ref']) && !empty($post['ref']))
            {   
                $refer_by = base64_decode($post['ref']);
                
                if($refer_by > 0)
                {   
                    $candidate_name = $post['name'];
                    $job_id = $obj_job->job_id;
                    (new SendNotificationController)->applyReferJobNotification($candidate_name,$refer_by,$job_id);
                }
            }
        }

        if($obj_application->id)
        {   

            if(!empty($specilist_companies) && in_array($post['current_company'], $specilist_companies) || (@$obj_job->employer->company_detail->company_name) &&  in_array($obj_job->employer->company_detail->company_name, $specilist_companies))
                {   
                    if(@$obj_job->secondary_specialist->id){
                        Job_application::where('id', $obj_application->id)->update(['specialist_id'=>$obj_job->secondary_specialist->id]);
                    }
            }else
            {
                if(@$obj_job->specialist->id)
                {
                    Job_application::where('id', $obj_application->id)->update(['specialist_id'=> $obj_job->specialist->id]);    
                }
            }
            // update candidate's new cv & cover letter
            $my_detail               = my_detail(); 
            $my_detail->resume       = $insert_arr['resume'];
            if(isset($insert_arr['cover_letter']))
            {
                $my_detail->cover_letter = $insert_arr['cover_letter'];
            }
            $my_detail->save();

            if(!empty($obj_job->primary_specialist_id) || !empty($obj_job->secondary_specialist_id))
            {
                $primary_specialist_id = $obj_job->primary_specialist_id;
                $secondary_specialist_id = $obj_job->secondary_specialist_id;
                $candidate_name = $post['name'];
                $job_id = $obj_job->job_id;

                (new SendNotificationController)->candidateApplyJobNotification($primary_specialist_id,$secondary_specialist_id,$candidate_name,$job_id);
                
            }

            request()->session()->flash('success','You have successfully applied on this job');
            
            $created_data = base64_encode(json_encode(['candidate_id'=>my_id(),'application_id'=>$obj_application->id]));

            return response()->json(['status'=>'success','data'=>$created_data,'slug'=>$job_slug,'msg'=>'You have successfully applied on this job']);
        }
        else
        {
            return response()->json(['status'=>'failed','msg'=>SOMETHING_WENT_WRONG]);
        }
    }

    // validate apply job form
    private function validate_job_form()
    {   
        $custom_error_msg   = [];
        $post               = request()->all();
        $my_detail          = my_detail(); 

        $rules = [
                    'name'  => 'required|max:100',
                    'email' => 'required|email|max:100',
                    'mobile'=> 'required|numeric|digits_between:8,15',
                    'cv_type'=>'required',
                    'cover_letter_type'=>'required'
                ];
        
        if(isset($post['cv_type']) && $post['cv_type'] == 'new')
        {
            $rules['new_cv'] = 'required|max:5120|mimes:doc,pdf,docx,zip';
            $custom_error_msg['new_cv.max'] = 'Size of file should not be more than 5MB.';
            $custom_error_msg['new_cv.required'] = 'Please upload new cv';
        }
        else if(!$my_detail->resume)
        {
            $rules['cv_type'] = 'required';
            $custom_error_msg['cv_type.required'] = 'It seems you did not uploaded any resume yet. Please upload resume from your profile section or apply with new resume';
            unset($post['cv_type']);
        }

        if(isset($post['cover_letter_type']) && $post['cover_letter_type'] == 'new')
        {
            $rules['new_cover_letter'] = 'required|max:5120|mimes:doc,pdf,docx,zip';
            $custom_error_msg['new_cover_letter.max'] = 'Size of file should not be more than 5MB.';
            $custom_error_msg['new_cover_letter.required'] = 'Please upload new cover letter or drag valid file';
        }
        else if(!$my_detail->cover_letter)
        {
            $rules['cover_letter_type'] = 'required';
            $custom_error_msg['cover_letter_type.required'] = 'It seems you did not uploaded any cover letter yet. Please upload cover letter from your profile section or apply with new cover letter';
            unset($post['cover_letter_type']);
        }

        // remove cover letter validation if file draged
        if(isset($post['drag_hidden1']) && $post['drag_hidden1'] == 'yes')
        {
            unset($rules['new_cover_letter']);
            unset($custom_error_msg['new_cover_letter.max']);
            unset($custom_error_msg['new_cover_letter.required']);
        }

        $validator  = Validator::make($post,$rules,$custom_error_msg);

        if($validator->fails())
        {    
            return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);exit;
        }
    }

    // show apply job form to friend's behalf
    public function show_friend_apply_job_form($job_slug)
    {       
        $this->data['obj_job'] = Employer_jobs::where(['slug'=>$job_slug,'status'=>'active'])->firstOrFail();

        return view('candidateApp.job.apply_job_friend_behalf',$this->data);
    }

    // apply job for friend
    public function apply_friend_job($job_slug)
    {   
        try
        {
            $post   = request()->all();

            if(!request()->ajax())
            {
                abort(404);
            }
            
            $obj_job = Employer_jobs::where('slug',$job_slug)->first();

            if(!$obj_job)
            {
                return response()->json(['status'=>'failed','msg'=>'Unable to find job id']);
            }

            $resp = $this->validate_friend_job_form();

            if($resp)
            {
                return $resp;
            }

            $insert_arr = ['job_id'=>$obj_job->id,'applied_by'=>my_id()];
            
            if(isset($post['ref']) && !empty($post['ref']))
            {   
                $refer_by = base64_decode($post['ref']);
                
                if($refer_by > 0)
                {   
                    $insert_arr['refer_by'] = $refer_by;
                }
            }

            $insert_arr['name'] = $post['name'];
            $insert_arr['email'] = $post['email'];
            $insert_arr['mobile'] = $post['mobile'];
            $insert_arr['current_company'] = $post['current_company'];
            $insert_arr['application_id']   = Job_application::getNextApplicationId();

            $arr = $this->upload_new_cv_cover_letter();
            $obj_candidate = $this->create_friend_account($arr,$obj_job);
            
            if(!$obj_candidate)
            {
                return response()->json(['status'=>'failed','msg'=>SOMETHING_WENT_WRONG]);
            }

            $insert_arr['candidate_id'] = $obj_candidate->id;

            $is_exist = Job_application::where($insert_arr)->first();

            $insert_arr = array_merge($insert_arr,$arr);

            if($is_exist) // already applied
            {
                $is_exist->updated_at = GMT_DATE_TIME;
                $is_exist->save();
                $obj_application = $is_exist;
            }
            else
            {   
                $obj_application = Job_application::create($insert_arr);
            }

            if($obj_application->id)
            { 
                $created_data = base64_encode(json_encode(['candidate_id'=>$obj_candidate->id,'application_id'=>$obj_application->id]));

                request()->session()->flash('success','Successfully applied on this job');

                return response()->json(['status'=>'success','data'=>$created_data,'msg'=>'Successfully applied on this job']);
            }
            else
            {
                return response()->json(['status'=>'failed','msg'=>SOMETHING_WENT_WRONG]);
            }
        }
        catch(Exception $e)
        {
            return response()->json(['status'=>'failed','msg'=>SERVER_ERR_MSG]);
        }
    }

    // validate friend apply job form
    private function validate_friend_job_form()
    {
        $custom_error_msg   = [];
        $post               = request()->all();
        
        $rules = [
                    'name'  => 'required|max:100',
                    'email' => 'required|email|max:100',
                    'mobile'=> 'required|numeric|digits_between:8,15',
                    'new_cv' => 'required|max:5120|mimes:doc,pdf,docx,zip',
                    'new_cover_letter' => 'required|max:5120|mimes:doc,pdf,docx,zip',
                ];

        $custom_error_msg['new_cv.max'] = 'Size of file should not be more than 5MB.';

        $custom_error_msg['new_cover_letter.max'] = 'Size of file should not be more than 5MB.';

        $custom_error_msg['new_cv.required'] = 'Please upload or drag valid resume';

        $custom_error_msg['new_cover_letter.required'] = 'Please upload or drag valid cover letter';

        // remove cover letter validation if file draged
        if(isset($post['drag_hidden1']) && $post['drag_hidden1'] == 'yes')
        {
            unset($rules['new_cv']);
            unset($custom_error_msg['new_cv.max']);
            unset($custom_error_msg['new_cv.required']);
        }

         // remove cover letter validation if file draged
        if(isset($post['drag_hidden2']) && $post['drag_hidden2'] == 'yes')
        {
            unset($rules['new_cover_letter']);
            unset($custom_error_msg['new_cover_letter.max']);
            unset($custom_error_msg['new_cover_letter.required']);
        }

        $validator  = Validator::make($post,$rules,$custom_error_msg);

        if($validator->fails())
        {    
            return response()->json(['status'=>'failed','type'=>'validation','msg'=>$validator->errors()->toarray()]);exit;
        }                
    }

    // create friend's account
    private function create_friend_account($cv_arr,$obj_job)
    {
        $post       = request()->all();
        $insert_arr = [];

        // check if user already exist

        $obj_candidate = Candidate::where('email',$post['email'])
                                    ->orWhere('phone',$post['mobile'])
                                    ->first();
        if($obj_candidate)
        {
            return $obj_candidate;
        }
        else
        {
            $name_arr = explode(' ',$post['name']);
            $password = randomPassword();

            $insert_arr['candidate_id'] = Candidate::getNextCandidateId();
            $insert_arr['name'] = $post['name'];
            $insert_arr['first_name'] = isset($name_arr[0])?$name_arr[0]:null;

            unset($name_arr[0]);

            $insert_arr['last_name'] = implode(' ',$name_arr);
            $insert_arr['email'] = $post['email'];
            $insert_arr['phone'] = $post['mobile'];
            $insert_arr['password'] = bcrypt($password);
            $insert_arr = array_merge($insert_arr,$cv_arr);

            $url = route('web.job_detail',[$obj_job->slug]);

            $mail_data['replacement'] = [
                'RECEIVER_NAME' => ucwords($post['name']),
                'SENDER_NAME' => ucwords(my_detail()->name),
                'EMAIL'     => $post['email'],
                'PASSWORD' => $password,
                'JOB_NAME' => $obj_job->position->name,
                'JOB_URL' => $url,
            ];

            $mail_data['to'] = $post['email'];

            $obj_user = Candidate::create($insert_arr);
            
            if($obj_user->id)
            {
                dispatch(new \App\Jobs\FriendBehalfAppliedJob($mail_data));
                return $obj_user;   
            }    
        }

        return false;
    }

    //private upload cv_cover_letter
    public function upload_new_cv_cover_letter()
    {   
        $obj_cv = request()->file('new_cv');
        $obj_cover = request()->file('new_cover_letter');

        $my_id      = my_id();
        $my_detail  = my_detail();

        $arr = [];
        
        // existing resume    
        if($my_detail->resume)
        {
            $arr['resume'] = $my_detail->resume;
        }

        // existing cover letter
        if($my_detail->cover_letter) 
        {
            $arr['cover_letter'] = $my_detail->cover_letter;
        }

        // resume
        if($obj_cv)
        {
            $file_extension = $obj_cv->extension();
            $file_name = 'resume_'.$my_id.'_'.time().'.'.$file_extension;

            $path = public_path().'/storage/candidate/resume';
            $resp = $obj_cv->move($path, $file_name);

            if(file_exists($path.'/'.$file_name))
            {
                $arr['resume'] = $file_name;

                if(request()->get('drag') && request()->get('drag') == true)
                {   
                    $params = request()->get('d');
                    if($params)
                    {   
                        $params = json_decode(base64_decode($params));

                        $candidate_id = $params->candidate_id;
                        $application_id = $params->application_id;
                        
                        // update candidate's resume
                        $obj_candidate = Candidate::find($candidate_id);
                        $obj_candidate->resume = $arr['resume'];
                        $obj_candidate->save();

                        // update application resume as well
                        $obj_application = Job_application::find($application_id);
                        $obj_application->resume = $arr['resume']; 
                        $obj_application->save();
                    }
                }
            }
        }

        // cover letter
        if($obj_cover)
        {
            $file_extension = $obj_cover->extension();
            $file_name = 'cover_'.$my_id.'_'.time().'.'.$file_extension;

            $path = public_path().'/storage/candidate/cover_letter';
            $resp = $obj_cover->move($path, $file_name);

            if(file_exists($path.'/'.$file_name))
            {   
                $arr['cover_letter'] = $file_name;

                if(request()->get('drag') && request()->get('drag') == true)
                {   
                    $params = request()->get('d');

                    if($params)
                    {   
                        $params = json_decode(base64_decode($params));

                        $candidate_id = $params->candidate_id;
                        $application_id = $params->application_id;
                        $obj_candidate = Candidate::find($candidate_id);

                        $obj_candidate->cover_letter = $arr['cover_letter'];
                        $obj_candidate->save();

                        // update application cover letter as well
                        $obj_application = Job_application::find($application_id);
                        $obj_application->cover_letter = $arr['cover_letter']; 
                        $obj_application->save();
                    }
                }
            }
        }
        return $arr;
    }

}
