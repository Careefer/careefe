<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class NewsletterTransformer extends TransformerAbstract
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
        $send_url = $base_url.'/'.$module_name.'/'.'send/'.$obj_model->id;
        $delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';

    
        $columns['title'] = $obj_model->title;
        $columns['user_group'] = $obj_model->user_group;
        $columns['subject'] = $obj_model->subject;
        $columns['created_at'] = display_date_time($obj_model->created_at);

        
        $columns['action'] = '<div class="action-wrap">
                                <span></span><span></span><span></span>
                                <div class="actions">
                                    <a class="btn btn-outline btn-circle btn-sm purple" href="javascript:void(0)" onclick="redirect_url($(this),'."'$edit_url'".',true)">
                                        Edit
                                    </a>

                                    <a class="btn btn-outline btn-circle btn-sm blue" href="javascript:void(0)" onclick="redirect_url($(this),'."'$send_url'".',true)">Send</a>

                                    <a class="btn btn-outline btn-circle btn-sm red" href="javascript:void(0)" onclick="redirect_url($(this),'."'$delete_url'".',true)">
                                        Delete
                                    </a>
                                    </div>
                                   </div>';
            
        return $columns;
    }
}