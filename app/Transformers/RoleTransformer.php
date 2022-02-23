<?php

namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;



class RoleTransformer extends TransformerAbstract
{   
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        
        $edit_url = route('role.edit',['role_id'=>$obj_model->id]);
        $delete_url = route('role.delete',['role_id'=>$obj_model->id]);


        $columns['name'] = $obj_model->name;
        $columns['description'] = $obj_model->description;

        $class_name = $obj_model->getTable();

        if($obj_model->status == 'active')
        {   
            $columns['status'] = '<a href="javascript:void(0);" class="status"  onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye"></i><span>Active</span></a>';
        }
        else
        {

            $columns['status'] = '<a href="javascript:void(0);" class="status"  onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }
        $columns['created_at'] = display_date_time($obj_model->created_at);

        $columns['action'] = '<div class="action-wrap">
                                <span></span><span></span><span></span>
                                <div class="actions">
                                    <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$edit_url'".',true)">
                                        Edit
                                    </a>
                                    <a class="btn btn-outline btn-circle btn-sm red" href="javascript:void(0)" onclick="confirmation('."'$delete_url'".','. "'Delete Role'".','."'Please confirm if you want to delete this role? '".')">
                                        Delete
                                    </a>
                                    </div>
                                   </div>';
            
        return $columns;
    }
}