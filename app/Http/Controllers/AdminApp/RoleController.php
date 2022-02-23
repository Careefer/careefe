<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu_model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission AS Permission_model;
use Yajra\DataTables\Facades\DataTables;
use App\Transformers\RoleTransformer;
use DB;
class RoleController extends Controller
{   
    public $data = [];

    public function role_listing()
    {   
        if(request()->ajax())
        { 

            $model = Role::where('name','<>','super-admin');
            return Datatables()->eloquent($model)
                        ->filter(function($query){
                             if(request()->has('status') && !empty(request('status')))
                                {       
                                    $query->where("status",request('status'));
                                }

                                if(request()->has('name') && !empty(request('name')))
                                {       
                                    $query->where("name","like","%".request()->get('name')."%");
                                }

                                if(request()->has('description') && !empty(request('description')))
                                {       
                                    $query->where("description","like","%".request()->get('description')."%");
                                }
                        })    
                        ->setTransformer(new RoleTransformer(new Role))
                        ->toJson();
        }    

        $this->data['active_menue']     = 'access-management';
        $this->data['active_sub_menue'] = 'manage-role';

        return view('role.role_listing',$this->data);      
    }

    // public function role_list_ajax()
    // {   
    //     return Datatables::of(Role::query()->where('name','<>','super-admin'))
    //     ->editColumn('created_at',function($obj_role){
    //         return $obj_role->created_at->format('d-m-Y h:i:s A');
    //     })
    //     ->editColumn('status',function($obj_role){
    //         // $active = '<a href="javascript:void(0);" onclick="change_status('."'Role','id','$obj_role->id','$obj_role->status','role_list_table'".');"><i class="fa fa-eye">Active</i></a>';

    //         // $inactive = '<a href="javascript:void(0);" onclick="change_status('."'Role','id','$obj_role->id','$obj_role->status','role_list_table'".');"><i class="fa fa-eye-slash">Inactive</i></a>';

    //         $class_name = $obj_role->getTable();

    //         if($obj_role->status == 'active')
    //         {   
    //             $status = '<a href="javascript:void(0);" onclick="change_status('."'".$class_name."','id','$obj_role->id','$obj_role->status'".');"><i class="fa fa-eye">Active</i></a>';
    //         }
    //         else
    //         {
    //             $status = '<a href="javascript:void(0);" onclick="change_status('."'".$class_name."','id','$obj_role->id','$obj_role->status'".');"><i class="fa fa-eye-slash">Inactive</i></a>';
    //         }
            
    //         //return ($obj_role->status == 'active')?$active:$inactive;
    //         return $status;
    //     })
    //     ->addColumn('action',function($obj_role){

    //         $edit_url = route('role.edit',['role_id'=>$obj_role->id]);

    //         $action_buttons = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>';

    //         $delete_url = route('role.delete',['role_id'=>$obj_role->id]);

    //         $action_buttons .= '<a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".','. "'Delete Role'".','."'Please confirm if you want to delete this role? '".')"><button class="btn btn-danger">Delete</button></a>';

    //         return $action_buttons;
    //     })
    //     ->rawColumns(['action','status'])
    //     ->make(true);
    // }

    public function add_role(Request $req)
    {	
        if($req->all())
        {  
            $validate = $req->validate([
                                        'title'       =>'required|max:100',
                                        'description' =>'required|max:500',
                                        'status'      =>'required|min:6|max:8',
                                        'menu_ids'    =>'required'
                                        ],
                                        ['menu_ids.required'=>'Please select atleast one module']
                                        );
            // create menues permissions                                        
            $this->create_menues_permissions();

            $obj_role              = new Role;
            $obj_role->name        = $req->input('title');
            $obj_role->description = $req->input('description');
            $obj_role->guard_name  = 'admin';
            $obj_role->status      = $req->input('status');
            $obj_role->save();

            if($obj_role->id)
            {
                $this->create_role_permissions($obj_role,$req);
                $req->session()->flash('success','Record has been created successfully.');
            }
            else
            {
                $req->session()->flash('error','Error record not created. Please try after sometime.');
            }
            return redirect()->route('role.list');
        }

        $menues = $this->get_menues();

        $this->data['active_menue']     = 'setting';
        $this->data['active_sub_menue'] = 'role';
        $this->data['menues'] = $menues;
        
    	return view('role.add_role',$this->data);
    }

    public function delete($role_id,Request $req)
    {   
        if(SUPER_ADMIN_ROLE_ID == $role_id)
            abort(401);
            
        $obj_role = Role::findOrFail($role_id);

        if($obj_role->delete())
        {
            $req->session()->flash('success','Record deleted successfully.');
        }
        else
        {
            $req->session()->flash('error','Record not deleted. Please contact to administrator');
        }
        return redirect()->route('role.list');
    }

    public function edit_role($role_id,Request $req)
    {
        $obj_role       =   Role::findOrFail($role_id);

        if($obj_role->editable == 0)
            abort(401);
        
        if($req->all())
        {
            $validate = $req->validate([
                'title'       =>'required|max:100',
                'description' =>'required|max:500',
                'status'      =>'required|min:6|max:8',
                'menu_ids'    =>'required'
                ],
                ['menu_ids.required'=>'Please select atleast one module']
                ); 
                
                //dd($req->all());
                // check menue permission if not exist then add                                        
                $this->create_menues_permissions();

                $obj_role->name        = $req->input('title');
                $obj_role->description = $req->input('description');
                $obj_role->guard_name  = 'admin';
                $obj_role->status      = $req->input('status');

                if($obj_role->save())
                {
                    $this->create_role_permissions($obj_role,$req);
                    $req->session()->flash('success','Record has been updated successfully.');
                }
                else
                {
                    $req->session()->flash('error','Error record not updated. Please try after sometime.');
                }
                return redirect()->route('role.list');
        } 

        $this->data['active_menue']     = 'setting';
        $this->data['active_sub_menue'] = 'role';
        $this->data['menues']           = $this->get_menues();
        $this->data['edit_data']        =  $obj_role->toarray();
        $this->data['my_permissions']   =  $this->filterMyPermissionNames($obj_role);

    	return view('role.edit_role',$this->data);
    }

    private function filterMyPermissionNames($obj_role)
    {
        $permission_arr = $obj_role->permissions->toarray();

        $permission_name_arr = [];

        if(is_array($permission_arr) && count($permission_arr) > 0)
        {
            foreach($permission_arr as $key => $value)
            {
                $permission_name_arr[] = $value['name'];
            }
        }
        return $permission_name_arr;
    }

    private function create_role_permissions(Role $obj_role,$req)
    {
        $permissions_arr = array_filter(explode(',', $req->input('menu_ids')));
        // get permissin ids
        $permission_objs = Permission_model::whereIn('name',$permissions_arr)->get();

        if($permission_objs->count() > 0)
        {       
            // remove all existing permissions of a role
            $obj_role->revokePermissionTo($obj_role->getAllPermissions()); 

            foreach ($permission_objs as $key => $obj_per)
            {   
                // create new fresh permissions of role    
                $obj_role->givePermissionTo($obj_per);
            }
        }
    }

    private function get_menues()
    {   
        $all_data = [];
        $menues = Menu_model::orderBy('sort','asc')->where(['parent'=>'0'])->get();

        if(count($menues) > 0)
        {
            foreach ($menues as $key_parent_menue => $parent_menue)
            {
                $all_data[$parent_menue->id] = $parent_menue;

                $all_data[$parent_menue->id]['sub_menue'] = Menu_model::orderBy('sort','asc')->where(['parent'=>$parent_menue->id])->get();
            }
        }
        return $all_data;
    }

    private function create_menues_permissions()
    {
        $all_menues = Menu_model::all();

        if(count($all_menues) > 0)
        {
            foreach ($all_menues as $key => $menues_value)
            {
                $this->check_menue_permission_exist($menues_value->permission_name.'-'.'view');
                $this->check_menue_permission_exist($menues_value->permission_name.'-'.'add');   
                $this->check_menue_permission_exist($menues_value->permission_name.'-'.'edit');   
                $this->check_menue_permission_exist($menues_value->permission_name.'-'.'del');   
            }            
        }
    }

    private function check_menue_permission_exist($permission_name)
    {   
        $obj_permission = Permission_model::where(['name'=>$permission_name])->get();

        // start get actual permission name without add/edit/del/view
        $permission_arr = explode('-',$permission_name);
        array_pop($permission_arr);
        $permission_menue = implode('-',$permission_arr);
        // end get permission name    

        // get menue id
        $menue_id = DB::table('menues')->where(['status'=>'active','permission_name'=>$permission_menue])->value('id');

        if(!$obj_permission->count())
        {  
            // create menue permission if record doesn't exist
            Permission_model::create(['name'=>$permission_name,'menue_id'=>$menue_id,'guard_name'=>'admin']);
        }   
    }
}
