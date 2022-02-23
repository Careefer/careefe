<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class MenuesTransformer extends TransformerAbstract
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


            //$action_buttons .= '<a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"><button class="btn btn-danger">Delete</button></a>';

        $columns = [
                    '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$obj_model->id.'"/><span></span></label>',
                   ];

        $columns[] = $obj_model->name;
        $columns[] = $obj_model->url;

        $class_name = $obj_model->getTable();
        if($obj_model->status == 'active')
        {   
            $columns[] = '<a href="javascript:void(0);" class="status"  onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye">Active</i></a>';
        }
        else
        {

            $columns[] = '<a href="javascript:void(0);" class="status"  onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash">Inactive</i></a>';
        }
        $columns[] = $obj_model->sort;

        
        $columns[] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>
            <a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"><button class="btn btn-danger">Delete</button></a>';
            
        return $columns;
    }
}