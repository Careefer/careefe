<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class JobApplicationTransformer extends TransformerAbstract
{  
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        //dd($obj_model);
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        $edit_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/edit/';
        $delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';

        $show_url = $base_url.'/'.$module_name.'/show/'.$obj_model->id;

        $class_name = $obj_model->getTable();

        $columns['application_id'] = $obj_model->application_id;
        $columns['name'] = ucwords($obj_model->name);

        $job_location = '';

        if($obj_model->job->cities())
        {
            $job_location .= implode(', ',$obj_model->job->cities());
            $job_location .= ",&nbsp";
        }

        if($obj_model->job->state())
        {
            $job_location .= "<b>".implode(', ',$obj_model->job->state())."</b>";
            $job_location .= ",&nbsp";
        }

        $job_location .= '<b>'.$obj_model->job->country->name."</b>";

        $columns['job_location'] = $job_location;


        $columns['job_id'] = $obj_model->job->job_id;
        $columns['job']['position']['name'] = $obj_model->job->position->name;
        $columns['job']['company']['company_name'] = $obj_model->job->company->company_name;

        if(isset($obj_model->candidate->current_location->world_location->location))
        {
            $columns['applicant_location'] = $obj_model->candidate->current_location->world_location->location;
        }
        else
        {
            $columns['applicant_location'] = '--';
        }

        if(isset($obj_model->job->primary_specialist->name))
        {
            $columns['job']['primary_specialist']['name'] = ucwords($obj_model->job->primary_specialist->name);
        }
        else
        {
            $columns['job']['primary_specialist']['name'] = '--';
        }

        $columns['mobile'] = $obj_model->mobile;
        $status = ucwords(str_replace('_', ' ', $obj_model->status));

        $columns['status'] = '<span class="label label-sm label-primary">'.$status.'</span>';

        $columns['created_at'] = display_date_time($obj_model->created_at);

        $actions = '
                    <div class="action-wrap">
                        <span></span><span></span><span></span>
                        <div class="actions">
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$show_url'".',true)">
                                View
                            </a>
                        </div>
                    </div>
                   ';

        $columns['action'] = $actions;
            
        return $columns;
    }
}