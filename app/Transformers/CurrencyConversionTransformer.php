<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class CurrencyConversionTransformer extends TransformerAbstract
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


        $columns['iso_code'] = $obj_model->iso_code;
        $columns['usd_value'] = $obj_model->usd_value;
        $columns['created_at'] = display_date_time($obj_model->created_at);
       

        $columns['action'] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>
            <a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"><button class="btn btn-danger">Delete</button></a>';

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
            
        return $columns;
    }
}