<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class CityTransformer extends TransformerAbstract
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
        $delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';

        $columns['name'] = $obj_model->name;

        $class_name = $obj_model->getTable();

        if($obj_model->status == 'active')
        {   
            $status = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye"></i><br><span>Active</span></a>';
        }
        else
        {

            $status = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }

        $columns['country']['name'] = (@$obj_model->country->name) ? $obj_model->country->name : ''  ;
        $columns['state']['name'] = (@$obj_model->state->name) ? $obj_model->state->name : '';
        $columns['status'] = $status;
        $columns['created_at'] = display_date_time($obj_model->created_at);
        
        $columns['action'] = '<div class="action-wrap">
                        <span></span><span></span><span></span>
                        <div class="actions">
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$edit_url'".',true)">
                                Edit
                            </a>
                            <a title="Delete" class="btn btn-outline btn-circle dark btn-sm red mt-sweetyalert"  href="javascript:void(0);" onclick="confirmation('."'$delete_url','Delete City','Do you want to delete this city ?'".')"> Delete
                            </a>
                        </div>
                    </div>';
            
        return $columns;
    }
}