<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class EmployerUnPaidPaymentTransformer extends TransformerAbstract
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

        //$show_url = $base_url.'/'.$module_name.'/show/'.$obj_model->id;
        $show_url = route('admin.employer-unpaid-payment-detail', [$obj_model->id]);
        $class_name = $obj_model->getTable();

        $columns['id'] = @$obj_model->id ?? '';
        $columns['job']['job_id'] = @$obj_model->job->job_id ?? '';
        $columns['job']['position']['name'] = @$obj_model->job->position->name ?? '';
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

        $columns['job']['company']['company_name'] = @$obj_model->job->company->company_name;
        $columns['commission'] = @$obj_model->commission ?? '';
        $columns['application']['name'] = @$obj_model->application? ucwords($obj_model->application->name) : '';

        $status = '';
        if($obj_model->is_paid==1){
            $status = 'Paid';
        }elseif($obj_model->is_paid==0){
            $status = 'Unpaid';
        }elseif($obj_model->is_paid==2){
            $status = 'On Hold';
        }elseif($obj_model->is_paid==3){
            $status = 'Cancelled';
        }

        $columns['is_paid'] = $status;

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