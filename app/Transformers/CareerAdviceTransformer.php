<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class CareerAdviceTransformer extends TransformerAbstract
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

        $columns['category']['title'] = ''; 

        if(isset($obj_model->category->title))
        {
            $columns['category']['title'] = $obj_model->category->title;
        }

        
        $columns['title'] = $obj_model->title;

        if($obj_model->type == "image")
        {
            $columns['image'] = '<img src="'.asset('storage/career_advice_images/thumbnail_image/'.$obj_model->image).'" alt="" height="80" width="80" class="rounded-circle">';
        }
        else
        {
            $columns['image'] = '<video width="150" height="150" controls>
                           <source src="'.asset('storage/career_advice_images/'.$obj_model->image).'">     
                          </video>';
        }

       

        $class_name = $obj_model->getTable();

        if($obj_model->status == 'active')
        {   
            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye"></i><br><span>Active</span></a>';
        }
        else
        {

            $columns['status'] = '<a href="javascript:void(0);" class="status" onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }
       

        $columns['action'] = '<div class="action-wrap">
                                <span></span><span></span><span></span>
                                <div class="actions">
                                    <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$edit_url'".',true)">
                                        Edit
                                    </a>
                                    <a class="btn btn-outline btn-circle btn-sm blue" href="javascript:void(0)" onclick="redirect_url($(this),'."'$show_url'".',true)">
                                        View
                                    </a>
                                    <a title="Delete" class="btn btn-outline btn-circle dark btn-sm red mt-sweetyalert" href="javascript:void(0);" onclick="confirmation('."'$delete_url','Delete Career Advice','Do you want to delete this career advice ?'".')">
                                        Delete
                                    </a></div>
                                </div>';
        return $columns;
    }
}