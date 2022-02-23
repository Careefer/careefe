<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Illuminate\Http\Request;
use Route;
use App;

class EmployerTransformer extends TransformerAbstract
{   

    /**
     * Display branch office in html format
     */
    public function filter_branch_offices($employer)
    {
        $html ='--';

        if(isset($employer->branch_offices) && !empty($employer->branch_offices))
        {   
            $html ='<ol style="list-style:none">';
            foreach ($employer->branch_offices as $key => $value)
            {   
                $html .="<li>$value->name,</li>";
            }
            $html .= '</ol>';
        }
        return $html;
    }

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

        $show_url = $base_url.'/'.$module_name.'/show/'.$obj_model->id;

        $class_name = $obj_model->getTable();

        if($obj_model->status == 'active')
        {   
            $status = '<a href="javascript:void(0);" class="status"  onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye"></i><span>Active</span></a>';
        }
        else
        {

            $status = '<a href="javascript:void(0);" class="status"  onclick="change_status('."'".$class_name."','id','$obj_model->id','$obj_model->status'".');"><i class="fa fa-eye-slash"></i><br><span>Inactive</span></a>';
        }

        $industry = '--';

        if(isset($obj_model->industry->name) && !empty($obj_model->industry->name))
        {
            $industry = $obj_model->industry->name;
        }

        $columns['employer_id'] = $obj_model->employer_id;
        $columns['name'] = ucwords($obj_model->name);
        $columns['head_office'] = $obj_model->head_office;
        $columns['branch_offices']['name'] = $this->filter_branch_offices($obj_model);
        $columns['industry']['name'] = $industry;
        $columns['status'] = $status;
        $columns['created_at'] = $status;
        
        
        $columns['action'] = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>
            <button class="btn btn-primary" onclick="redirect_url($(this),'."'$show_url'".',true)">Show</button>
            <a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".')"><button class="btn btn-danger">Delete</button></a>';
            
        return $columns;
    }
}