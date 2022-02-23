<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class BannerTransformer extends TransformerAbstract
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


        $columns['title'] = $obj_model->title;

        if($obj_model->type == "image")
        {
            $columns['image'] = '<img src="'.asset('storage/banner_images/'.$obj_model->image).'" alt="" height="80" width="80" class="rounded-circle">';
        }
        else
        {
            $columns['image'] = '<video width="150" height="150" controls>
                           <source src="'.asset('storage/banner_images/'.$obj_model->image).'">     
                          </video>';
        }

        $columns['type'] = $obj_model->type; 
        $class_name = $obj_model->getTable();

        if($obj_model->status == 'active')
        {   
            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye"></i><span>Active</span></a>';
        }
        else
        {

            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }
       
       $columns['updated_at'] = display_date_time($obj_model->updated_at); 

        $columns['action'] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button><button class="btn btn-info" onclick="redirect_url($(this),'."'$show_url'".',true)">View</button>';
            
        return $columns;
    }
}