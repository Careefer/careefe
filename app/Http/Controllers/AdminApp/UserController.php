<?php

namespace App\Http\Controllers\AdminApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Transformers\AdminTransformer;


class UserController extends Controller
{   
    private $data = [];
    
    public function add(Request $req)
    {   
        if($req->all())
        {   
            $validate = $req->validate([
                'role'      => 'required',
                'name'      => 'required|max:255',
                'email'     => 'required|email|max:255|unique:admins',
                'password'  => 'required|min:6|confirmed',
                'status'    => 'required',
            ]);

            $admin_obj =  Admin::create([
                            'name'      => $req->input('name'),
                            'email'     => $req->input('email'),
                            'password'  => bcrypt($req->input('password')),
                            'status'    => $req->input('status')
                        ]);

            if(isset($admin_obj->id) && $admin_obj->id > 0)
            {   
                $obj_role = Role::find($req->input('role'));
                if($obj_role)
                {
                    $admin_obj->assignRole($obj_role);
                }
                $req->session()->flash('success','User has been created successfully.');
            }
            else
            {
                $req->session()->flash('error','Error user not created. Please try after sometime.');
            }
            return redirect(route('user.list'));
        }
        $role_list = Role::all();

        $this->data['active_menue']     = 'setting'; 
        $this->data['active_sub_menue'] = 'admin-user';
        $this->data['role_list']        =  $role_list;

        return view('user.add_user',$this->data);
    }
    
    public function edit($user_id , Request $req)
    {  
        if($user_id == SUPER_ADMIN_ID)
            abort(401);
        
        $obj_user   = Admin::findOrFail($user_id);
        
        if($req->all())
        {   
            $rules = [
                'role'      => 'required',
                'name'      => 'required|max:255',
                'email'     => "required|email|max:255|unique:admins,email,$user_id",
                'status'    => 'required',
            ];

            $pass_change = false;

            if(!empty($req->input('password')))
            {
                $rules['password'] = 'required|min:6|confirmed';

                $pass_change = true;
            }
            $validate = $req->validate($rules);

            $obj_user->name     =  $req->input('name');           
            $obj_user->email    =  $req->input('email');           
            $obj_user->status   =  $req->input('status');                     

            $obj_role = Role::find($req->input('role'));

            if($obj_role)
            {
                // delete existing and assign current one role
                $obj_user->syncRoles($req->input('role'));
            }

            if($pass_change)
            {
                $obj_user->password =   Hash::make($req->input('password'));
            }
            if($obj_user->save())
            {
                $req->session()->flash('success','User updated successfully.');
            }
            else
            {
                $req->session()->flash('error','User not updated. Please try after sometime');
            }
            return redirect()->route('user.list');
        }

        $role_list  = Role::all();

        $this->data['active_menue']     = 'setting'; 
        $this->data['active_sub_menue'] = 'admin-user';
        $this->data['obj_user']         = $obj_user;
        $this->data['role_list']        = $role_list;

        return view('user.edit_user',$this->data);
    }

    public function delete($user_id,Request $req)
    {   
        if($user_id == SUPER_ADMIN_ID)
            abort(401);

        $obj_user = Admin::FindOrFail($user_id);

        if($obj_user->delete())
        {
            $req->session()->flash('success','User deleted successfully.');
        }
        else
        {
            $req->session()->flash('error','Error User Not deleted. Please try again');
        }
        return redirect()->route('user.list');
    }
    
    public function listing()
    {  
        if(request()->ajax())
        {   
            $model = Admin::query();
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

                                if(request()->has('email') && !empty(request('email')))
                                {       
                                    $query->where("email","like","%".request()->get('email')."%");
                                }
                        })    
                        ->setTransformer(new AdminTransformer(new Admin))
                        ->toJson();
        }

        $this->data['active_menue']     = 'access-management'; 
        $this->data['active_sub_menue'] = 'manage-administrator'; 
        return view('user.user_listing',$this->data);
    }

    /*public function user_listing_ajax()
    {
        return Datatables::of(Admin::query())
        ->editColumn('created_at',function($obj_admin){
            return $obj_admin->created_at->format('d-m-Y h:i:s A');
        })
        ->editColumn('status',function($obj_admin){
            
            //$active = '<a href="javascript:void(0);" onclick="change_status('."'Admin','id','$obj_admin->id','$obj_admin->status','user_list_table'".');"><i class="fa fa-eye">Active</i></a>';

            //$inactive = '<a href="javascript:void(0);" onclick="change_status('."'Admin','id','$obj_admin->id','$obj_admin->status','user_list_table'".');"><i class="fa fa-eye-slash">Inactive</i></a>';

            $class_name = $obj_admin->getTable();

            if($obj_admin->status == 'active')
            {   
                $status = '<a href="javascript:void(0);" onclick="change_status('."'".$class_name."','id','$obj_admin->id','$obj_admin->status'".');"><i class="fa fa-eye">Active</i></a>';
            }
            else
            {
                $status = '<a href="javascript:void(0);" onclick="change_status('."'".$class_name."','id','$obj_admin->id','$obj_admin->status'".');"><i class="fa fa-eye-slash">Inactive</i></a>';
            }
            
            //return ($obj_admin->status == 'active')?$active:$inactive;
            return $status;
        })
        ->addColumn('action',function($obj_admin){

            $edit_url = route('user.edit',['user_id'=>$obj_admin->id]);
       
            $action_buttons = '<button class="btn btn-success" onclick="redirect_url($(this),'."'$edit_url'".',true)">Edit</button>';
        
            $delete_url = route('user.delete',['user_id'=>$obj_admin->id]);

            $action_buttons .= '<a href="javascript:void(0);" onclick="confirmation('."'$delete_url'".','. "'Delete Admin User'".','."'Please confirm if you want to delete this admin user? '".')"><button class="btn btn-danger">Delete</button></a>';

            return $action_buttons;
        })
        ->addColumn('role',function($admin_obj){
            $role = $admin_obj->getRoleNames()->toarray();
            return ($role) ? $role : 'Not assigned';
        })
        ->rawColumns(['action','status'])
        ->make(true);            
    }*/

    public function my_profile(Request $req)
    {   
        if(!session('current_tab'))
        {
            $req->session()->flash('current_tab','info');
        }
        return view('user.my_profile');
    }

    public function change_profile_image(Request $req)
    {
        $req->validate( [
                            'profile' => 'required|image|max:5120'
                        ],
                        [
                            'required' => 'Profile image is required',
                            'max'  => 'Profile image`s size can be max 5MB'
                        ]
                    );

        $file_extension = $req->file('profile')->getClientOriginalExtension();
        $file_name      = slug_url(Auth::user()->name.'-'. Auth::user()->id).'.'.$file_extension;
        $path           = $req->file('profile')->storeAs('public/admin_profile_images',"$file_name");
        $upload         = true;

        if($path)
        {
            $obj_auth = Auth::user();
            $obj_auth->profile_image = $file_name;
            $obj_auth->save();

            if($obj_auth->save())
            {
                $req->session()->flash('success','Profile image updated successfully');
            }
            else
            {
                $req->session()->flash('error','Error profile image not updated. Please try again.');
            }
        }
        else
        {
            $req->session->flash('error','Error profile image not updated. Please try again.');
        }

        return redirect()->back();
    }

    public function update_my_info(Request $req)
    {
        $req->validate([
                'name'      =>  'required|max:100|min:2',
                'email'     =>  'required|email|max:100|min:2',
                'mobile'    =>  'required|digits:10'
        ]);

        $obj_auth = Auth::user();
        $obj_auth->name = $req->get('name');
        $obj_auth->email = $req->get('email');
        $obj_auth->mobile = $req->get('mobile');

        if($obj_auth->save())
        {
            $req->session()->flash('success','Profile data saved successfully');
        }
        else
        {
            $req->session()->flash('error','Profile data not saved. Please try after sometime');
        }
        return redirect()->back();
    }

    public function change_password(Request $req)
    {   
        $req->session()->flash('current_tab','password');
        
        $validator = Validator::make($req->all(),[
            'current_password' => [
                'required',
                'max:15',
                'min:6',
                function($attribute,$value, $fail)
                {   
                    $current_pass = Auth::user()->password;
                    if(!Hash::check($value,$current_pass))
                    {
                        $fail('Incorrect old password');
                    }
                }               
            ],
            'new_password' => [
                    'required',
                    'max:15',
                    'min:6',
                ],
                're_enter_new_password' => [
                    'required',
                    'same:new_password'
                ]
        ])->validate();

        $new_password = Hash::make($req->get('new_password'));

        $obj  = Auth::user();

        $obj->password = $new_password;
        
        if($obj->save())
        {
            $req->session()->flash('success','Password changed successfully');
        }
        else
        {
            $req->session()->flash('error','Error password not changed Please try again');
        }
        return redirect()->back();                    
    }


}
