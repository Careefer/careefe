<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class SpecialistPaymentSummaryTransformer extends TransformerAbstract
{  
    /**
     * @param \App\User $user
     * @return array
     */
    public function transform($obj_model)
    {   
        $base_url    = App::make('url')->to('/');
        $module_name = Route::getFacadeRoot()->current()->uri();

        $show_url = $base_url.'/'.$module_name.'/show/'.$obj_model->id;

        $class_name = $obj_model->getTable();

        $columns['specilist']['name'] = @$obj_model->specilist->name ? $obj_model->specilist->name : '-';

        $columns['specilist']['country'] = (@$obj_model->specilist->get_country_from_bank_detail) ? @$obj_model->specilist->get_country_from_bank_detail[0]->get_country_name->name : '-';

        $columns['total_paid'] = $obj_model->specialistTotalPayments();

        $columns['total_unpaid'] = $obj_model->specialistTotalOutstandingPayments();  
            
        return $columns;
    }
}