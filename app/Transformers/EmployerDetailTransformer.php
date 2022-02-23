<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use Illuminate\Http\Request;
use Route;
use App;



class EmployerDetailTransformer extends TransformerAbstract
{   
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();
        
        //$edit_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/edit/';
        $show_url = $base_url.'/'.$module_name.'/'.'make_featured/'.$obj_model->id;
        //$delete_url = $base_url.'/'.$module_name.'/'.$obj_model->id.'/delete/';

    
        $columns[] = $obj_model->company_name;

        $columns[] = '<img src="'.asset('storage/employer/company_logo/'.$obj_model->logo).'" alt="" height="80" width="80" class="rounded-circle">';
        
        $columns[] = $obj_model->website_url;
        $columns[] = display_date_time($obj_model->created_at);

        
        $columns[] = '<button class="btn btn-info" onclick="redirect_url($(this),'."'$show_url'".',true)">Make Featured</button>';
            
        return $columns;
    }
}