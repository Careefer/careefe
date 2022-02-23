<?php

namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;



class BankFormatTransformer extends TransformerAbstract
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
        
        //$columns['total_country'] = $obj_model->bank_format_countries->count();
        $countryNames = $obj_model->bank_format_countries_name ? $obj_model->bank_format_countries_name->pluck('name')->toArray() : [];
        
        $columns['total_country'] =  implode(', ', $countryNames);

        $columns['updated_at'] = display_date_time($obj_model->updated_at);

        $class_name = $obj_model->getTable();

        $columns['action'] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>';
            
        return $columns;
    }
}