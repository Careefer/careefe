<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class CommanTransformer extends TransformerAbstract
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

        // $columns = [
        //             '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"><input name="id[]" type="checkbox" class="checkboxes" value="'.$obj_model->id.'"/><span></span></label>',
        //            ];

        foreach ($obj_model->getFillable() as $key => $column_name)
        {      
            if($column_name == 'status')
            {   
                //$table_name = 'datatable_ajax';

                $class_name = $obj_model->getTable();

                if($obj_model->$column_name == 'active')
                {   
                    $status = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye"></i><br><span>Active</span></a>';
                }
                else
                {

                    $status = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
                }

                $columns[] = $status;
            }
            else
            {
                $columns[] = $obj_model->$column_name;   
            }
        } 

        $columns[] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>
            <a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"><button class="btn btn-danger">Delete</button></a>';
            
        return $columns;
    }
}