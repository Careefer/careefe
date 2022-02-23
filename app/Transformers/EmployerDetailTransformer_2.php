<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class EmployerDetailTransformer_2 extends TransformerAbstract
{   
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        
        $edit_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/edit/';
        $show_url = $base_url.'/'.$module_name.'/'.'show/'.$obj_model->id;
        $delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';
        $acc_url = $base_url.'/admin/employers/list_associated_acc/'.$obj_model->id;
        $reset_url = $base_url.'/admin/employers/reset_password/'.$obj_model->id;
        $featured_url = route('manage_companies.manage_company.make_featured', $obj_model->id);

        $class_name = $obj_model->getTable();
        
        $columns['employer_id'] = $obj_model->employer_id;
        

        $columns['company_name'] = $obj_model->company_name;

        $columns['head_office']['location'] = '';
        if($obj_model->head_office->location)
        {
            $columns['head_office']['location'] = $obj_model->head_office->location;
        }

        $columns['industry']['name'] = '--';
        if(isset($obj_model->industry->name))
        { 
            $columns['industry']['name'] = $obj_model->industry->name;
        }


        if($obj_model->status == 'active')
        {   
            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');" Click to inactive><i class="fa fa-eye"></i><span>Active</span></a>';
        }
        else
        {

            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');" title="Click to active"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }


        $data = (!empty($obj_model->branch_locations()) ? $obj_model->branch_locations() : [] );

        $columns['branch'] = '';

        if(!empty($data)){
            $count=1;
            foreach ($data as $key => $value)
            {
              $columns['branch'] .=  $count.'. '. $value.'<br>';
              $count++;
            }
        }

        
        $columns['created_at'] = '--';
        
        if($obj_model->created_at)
        {
            $columns['created_at'] = display_date_time($obj_model->created_at);
        }

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
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$acc_url'".',true)">
                                Accounts
                            </a>
                           ';

                   if($obj_model->is_featured == 'yes')
                   {
                        $actions .= '<a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$featured_url'".',true)">
                                    Make Unfeatured
                                </a>';  
                   }else
                   {
                    $actions .= '<a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$featured_url'".',true)">
                                Make Featured
                            </a>';
                   }

                  $actions .= '<a title="Delete" class="btn btn-outline btn-circle dark btn-sm red mt-sweetyalert"  href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"> Delete
                            </a>';


                    $actions .= '</div>
                    </div>
                   ';

        $columns['action'] = $actions;                   
            
        return $columns;
    }
}