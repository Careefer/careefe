<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class SpecialistTransformer extends TransformerAbstract
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

        $show_url = $base_url.'/'.$module_name.'/show/'.$obj_model->id;

        $class_name = $obj_model->getTable();

        $columns['specialist_id']   = $obj_model->specialist_id;
        $columns['name']            = ucwords($obj_model->name);
        $columns['email']           = $obj_model->email;
        $columns['phone']           = $obj_model->phone;
        
        $columns['current_location']['world_location']['location'] = '--';

        if(isset($obj_model->current_location->world_location->location))
        {
            $columns['current_location']['world_location']['location'] = $obj_model->current_location->world_location->location;
        }

        $columns['functional_areas'] = '';
        if($obj_model->functional_area())
        {   
            $arr = $obj_model->functional_area();
            $columns['functional_areas'] = ($arr)?implode(', ', $arr):'--';
        }

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
                                Edit Specialist
                            </a>
                            <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$show_url'".',true)">
                                View details
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