<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class EmployerPaidPaymentTransformer extends TransformerAbstract
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
        $show_url = route('admin.employer-paid-payment-detail', [$obj_model->id]);
        $class_name = $obj_model->getTable();

        $columns['job']['job_id'] = @$obj_model->job->job_id ?? '';
        $columns['txn_id'] = @$obj_model->txn_id ?? '';
        $columns['job']['position']['name'] = @$obj_model->job->position->name ?? '';
        $columns['job']['company']['company_name'] = @$obj_model->job->company->company_name;
        $columns['commission'] = @$obj_model->commission ?? '';
        $columns['application']['name'] = @$obj_model->application? ucwords($obj_model->application->name) : '';
        $columns['is_paid'] = (@$obj_model->is_paid == 1)? "Paid" : 'Unpaid';

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