<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class RefereePaymentSummaryTransformer extends TransformerAbstract
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

        $columns['name'] = (@$obj_model->user_type == 'candidate') ? $obj_model->candidate->name : ($obj_model->user_type == 'referre-specialist' ? $obj_model->specilist->name : '-');

        $columns['country'] = '';
        if($obj_model->user_type == 'candidate')
        {
            $columns['country'] = (@$obj_model->candidate->get_country_from_bank_detail) ? @$obj_model->candidate->get_country_from_bank_detail[0]->get_country_name->name : '-';

        }elseif($obj_model->user_type == 'referre-specialist'){
            $columns['country'] = (@$obj_model->specilist->get_country_from_bank_detail) ? @$obj_model->specilist->get_country_from_bank_detail[0]->get_country_name->name : '-';
        }

        $columns['total_paid'] = $obj_model->refereeTotalPayments();

        $columns['total_unpaid'] = $obj_model->refereeTotalOutstandingPayments();  
            
        return $columns;
    }
}