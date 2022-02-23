<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class MessageTransformer extends TransformerAbstract
{   
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        
        $show_url = $base_url.'/'.$module_name.'/'.'show/'.$obj_model->room_id;
        $delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';

        if(!empty($obj_model->candidate))
        {
             $columns['sender_name'] = $obj_model->candidate->name;
             $columns['message'] = $obj_model->last_message;
             $columns['user_type'] = 'Candidate';
             $columns['job_card'] = ''; 
             $columns['application_card'] = '';
             if(!empty($obj_model->job))
             {
                $obj_job = $obj_model->job;
                $columns['job_card'] = $obj_job->position->name." , ".$obj_job->employer->name." , ".$obj_model->job->job_id;
             }
             if(!empty($obj_model->application))
             {
                $columns['application_card'] = $obj_model->application->application_id." , ".$obj_model->application->name;
             }
             $columns['date'] = display_date_time($obj_model->last_message_date_time);
        }
        
        if(!empty($obj_model->specialist))
        {
             $columns['sender_name'] = $obj_model->specialist->name;
             $columns['message'] = $obj_model->last_message;
             $columns['user_type'] = 'Specialist';
             $columns['job_card'] = '';
             $columns['application_card'] = '';
             if(!empty($obj_model->job))
             {
                $obj_job = $obj_model->job;
                $columns['job_card'] = $obj_job->position->name." , ".$obj_job->employer->name." , ".$obj_model->job->job_id;
             }
             if(!empty($obj_model->application))
             {
                $columns['application_card'] = $obj_model->application->application_id." , ".$obj_model->application->name;
             }
             $columns['date'] = display_date_time($obj_model->last_message_date_time);
        }

        if(!empty($obj_model->employer))
        {
             $columns['sender_name'] = $obj_model->employer->name;
             $columns['message'] = $obj_model->last_message;
             $columns['user_type'] = 'Employer';
             $columns['job_card'] = '';
             $columns['application_card'] = '';
             if(!empty($obj_model->job))
             {
                $obj_job = $obj_model->job;
                $columns['job_card'] = $obj_job->position->name." , ".$obj_job->employer->name." , ".$obj_model->job->job_id;
             }
             if(!empty($obj_model->application))
             {
                $columns['application_card'] = $obj_model->application->application_id." , ".$obj_model->application->name;
             }
             $columns['date'] = display_date_time($obj_model->last_message_date_time);
        }


        $columns['action'] = '<div class="action-wrap">
                                <span></span><span></span><span></span>
                                <div class="actions">
                                    <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$show_url'".',true)">
                                        View
                                    </a>
                                    <a class="btn btn-outline btn-circle btn-sm red" href="javascript:void(0)" onclick="redirect_url($(this),'."'$delete_url'".',true)">
                                        Delete
                                    </a></div>
                                </div>';
            
        return $columns;
    }
}