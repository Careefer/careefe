<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;

class EmployerAssociatedAccountTransformer extends TransformerAbstract
{   
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   

        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        $class_name = $obj_model->getTable();
        
        $edit_url = $base_url.'/admin/employers/edit_associated_acc/'.$obj_model->id;

        $delete_url = $base_url.'/admin/employers/delete_associated_acc/'.$obj_model->id;
        
        $columns['employer_id'] = $obj_model->employer_id;
        
        $columns['name'] = $obj_model->name;
        $columns['email'] = $obj_model->email;
        $columns['mobile'] = $obj_model->mobile;

        $columns['my_location']['location'] = '--';
        if(isset($obj_model->my_location->location))
        {
            $columns['my_location']['location'] = $obj_model->my_location->location;
        }

        $columns['currency']['name'] = '--';
        if(isset($obj_model->currency->name))
        {
            $columns['currency']['name'] = $obj_model->currency->name;
        }

        $columns['timezone']['name'] = '--';
        if(isset($obj_model->timezone->name))
        {
            $columns['timezone']['name'] = $obj_model->timezone->name;
        }


        $columns['created_at'] = display_date_time($obj_model->created_at);


        if($obj_model->status == 'active')
        {   
            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');" Click to inactive><i class="fa fa-eye"></i><span>Active</span></a>';
        }
        else
        {

            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');" title="Click to active"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }

        $actions = '
                    <div class="action-wrap">
                        <span></span><span></span><span></span>
                        <div class="actions">
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$edit_url'".',true)">
                                Edit
                            </a>
                            <a title="Delete" class="btn btn-outline btn-circle dark btn-sm red mt-sweetyalert"  href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"> Delete
                            </a>
                        </div>
                    </div>
                   ';

       $columns['action'] = $actions;

        /*$columns['action'] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>
            <a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"><button class="btn btn-danger">Delete</button></a>';*/
            
        return $columns;
    }
}