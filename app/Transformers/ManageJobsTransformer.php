<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class ManageJobsTransformer extends TransformerAbstract
{   
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = '/admin/jobs';
        
        $edit_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/edit/';
        $show_url = $base_url.'/'.$module_name.'/'.'show/'.$obj_model->id;
        $delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';


        $columns['job_id'] = $obj_model->job_id;
        $columns['company']['company_name'] = isset($obj_model->company->company_name)?$obj_model->company->company_name:'--';

        $columns['position']['name'] = isset($obj_model->position->name)?$obj_model->position->name:"--";

        $columns['work_type']['name'] = isset($obj_model->work_type->name)?$obj_model->work_type->name: "--";

        $job_location = '';
        if($obj_model->cities())
        {
            $job_location .= implode(', ',$obj_model->cities());
            $job_location .= ",&nbsp";
        }
        if($obj_model->state())
        {
            $job_location .= "<b>".implode(', ',$obj_model->state())."</b>";
            $job_location .= ",&nbsp";
        }
        $job_location .= '<b>'.$obj_model->country->name."</b>";

        $columns['job_location'] = $job_location;


        $columns['created_at'] = display_date_time($obj_model->created_at);
        
        if(!empty($obj_model->jobSpecialist) && @$obj_model->jobSpecialist->primary_specialist_status == 'decline' || @$obj_model->jobSpecialist->secondary_specialist_status == 'decline'){
        $columns['specialist']['name'] = (@$obj_model->jobSpecialist->primary_specialist_status == 'decline' && @$obj_model->jobSpecialist->secondary_specialist_status == 'decline') ? $obj_model->primary_specialist->name .', '.$obj_model->secondary_specialist->name : (@$obj_model->jobSpecialist->primary_specialist_status == 'decline' ? $obj_model->primary_specialist->name : (@$obj_model->jobSpecialist->secondary_specialist_status == 'decline'? $obj_model->secondary_specialist->name : $obj_model->specialist->name )) ;     
        }else{
        $columns['specialist']['name'] = isset($obj_model->specialist->name)?$obj_model->specialist->name:"--";
        }   
        

        if($obj_model->commission_type == "percentage")
        {
            $columns['commission_amt'] = $obj_model->commission_amt."%";
        }
        else
        {
            $columns['commission_amt'] = display_price($obj_model->commission_amt);
        }
        
        $columns['referral_bonus_amt'] = display_price($obj_model->referral_bonus_amt);

        $columns['specialist_bonus_amt'] = display_price($obj_model->specialist_bonus_amt); 

        $columns['total_views'] = ($obj_model->total_views)?$obj_model->total_views:'0';
        $columns['no_of_applications'] = ($obj_model->applications())?$obj_model->applications() :0;

        $status = '--';
        switch ($obj_model->status)
        {
            case 'active':
                $status = '<span class="label label-sm label-success">Active</span>';
                break;

            case 'on_hold':
                $status = '<span class="label label-sm label-warning">On hold</span>';
                break;

            case 'pending':
                $status = '<span class="label label-sm label-danger">Pending</span>';
                break;

            case 'closed':
                $status = '<span class="label label-sm label-danger">Closed</span>';
                break;

            case 'cancelled':
                $status = '<span class="label label-sm label-danger">Cancelled</span>';
                break;   
        }
        
        $columns['status'] = $status;        

        $actions = '
                    <div class="action-wrap">
                        <span></span><span></span><span></span>
                        <div class="actions">
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$edit_url'".',true)">
                                Edit
                            </a>
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$show_url'".',true)">
                                View
                            </a>
                            <a title="Delete" class="btn btn-outline btn-circle dark btn-sm red mt-sweetyalert"  href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"> Delete
                            </a>
                        </div>
                    </div>
                   ';

        $columns['action'] = $actions;
            
        return $columns;
    }
}