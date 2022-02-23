<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class JobReferralApplicationsTransformer extends TransformerAbstract
{  
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        
        $show_url = $base_url.'/'.$module_name.'/show/'.$obj_model->id;

        $columns['application_id'] = @$obj_model->application_id ?? '';
        $columns['name'] = ucwords($obj_model->name);
        $columns['email'] = @$obj_model->email ?? '';
        $columns['mobile'] = @$obj_model->mobile ?? '';
        $columns['refer_by'] = @$obj_model->referred_by->name ?? '';
        $columns['job_id'] = @$obj_model->job->job_id ??'';
        $columns['job']['position']['name'] =  '';
        if(isset($obj_model->job->position->name)){
            $columns['job']['position']['name'] = @$obj_model->job->position->name ?? '';    
        }

        $columns['job']['company']['company_name'] = '';

        if(isset($obj_model->job->company->company_name)){
            $columns['job']['company']['company_name'] = @$obj_model->job->company->company_name ?? '';
        }
        
        $job_location = '';

        if(@$obj_model->job)
        {
            $job_location .= implode(', ',@$obj_model->job->cities());
            $job_location .= ",&nbsp";
        }

        if(@$obj_model->job)
        {
            $job_location .= "".implode(', ',@$obj_model->job->state())."";
            $job_location .= ",&nbsp";
        }

        $job_location .= ''. @$obj_model->job->country->name??''."";

        $columns['job_location'] = $job_location;

        $columns['job_status'] = ucwords(str_replace('_', ' ', @$obj_model->job->status));
        $columns['status'] = ucwords(str_replace('_', ' ', @$obj_model->status));

        $columns['created_at'] = display_date_time($obj_model->created_at);

        $columns['action'] = '<button class="btn btn-primary" onclick="redirect_url($(this),'."'$show_url'".',true)">View details</button>';
            
        return $columns;
    }
}