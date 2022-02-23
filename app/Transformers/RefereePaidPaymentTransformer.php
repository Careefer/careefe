<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class RefereePaidPaymentTransformer extends TransformerAbstract
{  
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        $show_url = route('admin.referee-paid-payment-detail', [$obj_model->id]);
        $class_name = $obj_model->getTable();

        $columns['job']['job_id'] = @$obj_model->job->job_id ?? '';
        $columns['txn_id'] = @$obj_model->txn_id ?? '';
        $columns['job']['position']['name'] = @$obj_model->job->position->name ?? '';
        $columns['job']['company']['company_name'] = @$obj_model->job->company->company_name;

        $columns['amount'] = $obj_model->amount;

        $columns['referee_name'] = (@$obj_model->user_type == 'candidate') ? $obj_model->candidate->name : ($obj_model->user_type == 'referre-specialist' ? $obj_model->specilist->name : '-');

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

        $columns['bank_detail'] = '';

        if($obj_model->user_type == 'candidate')
        {
            $dta1 = '-';
            if(@$obj_model->candidate->get_country_from_bank_detail)
            {
                 $dta1 .= (@$obj_model->candidate->get_country_from_bank_detail) ?"Country - ". @$obj_model->candidate->get_country_from_bank_detail[0]->get_country_name->name.'<br>' : '- <br>';
                foreach ($obj_model->candidate->get_country_from_bank_detail as $key => $value) 
                {
                    $dta1 .= $value->label.' - '.$value->value.'<br>';
                }    
                
                $columns['bank_detail'] = $dta1;   
            }

        }elseif($obj_model->user_type == 'referre-specialist')
        {   $dta = '';
            if(@$obj_model->specilist->get_country_from_bank_detail)
            {
                 $dta .= (@$obj_model->specilist->get_country_from_bank_detail) ?"Country - ". @$obj_model->specilist->get_country_from_bank_detail[0]->get_country_name->name.'<br>' : '- <br>';
                foreach ($obj_model->specilist->get_country_from_bank_detail as $key => $value) 
                {
                    $dta .= $value->label.' - '.$value->value.'<br>';
                }

               $columns['bank_detail'] = $dta;     
            }
        }


        $actions = '<div class="action-wrap">
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