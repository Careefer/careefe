<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployerFormRequest;
use App\Models\EmployerDetail;
use App\Models\Industry;
use App\Models\Employer_branch_office;
use App\Models\WorldLocation;
use App\Models\Currency;
use App\Models\TimeZones;
use App\Employer;
use App\Transformers\EmployerDetailTransformer_2;
use App\Transformers\EmployerAssociatedAccountTransformer;
use Exception;



class EmployersController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-users';
    }
    /**
     * Display a listing of the employers.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {   
        if(request()->ajax())
        {   
            
            $model = EmployerDetail::with(['head_office','industry']);


            if(request()->has('head_office') && !empty(request()->get('head_office')))
            {   
                $model = $model->whereHas('head_office',function($query){
                    
                    $query->where("location","like","%".request()->get('head_office')."%");
                });
            }

            if(request()->has('industry') && !empty(request()->get('industry')))
            {   
                $model = $model->whereHas('industry',function($query){
                    
                    $query->where("name","like","%".request()->get('industry')."%");
                });
            }

            return datatables()->eloquent($model->latest())
                        ->filter(function($q){

                            if(request()->has('employer_id') && !empty(request()->get('employer_id')))
                            {   
                                $q->where("employer_id","like","%".request()->get('employer_id')."%");
                            }

                            if(request()->has('company_name') && !empty(request()->get('company_name')))
                            {   
                                $q->where("company_name","like","%".request()->get('company_name')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {   
                                $q->where("status",request()->get('status'));
                            }

                        }, true)
                        ->setTransformer(new EmployerDetailTransformer_2(new EmployerDetail))
                        ->toJson();
        }
        
        $this->data['active_sub_menue'] = 'employer';
        return view('employers.index',$this->data);
    }

    /**
     * Show the form for creating a new employer.
     *
     * @return Illuminate\View\View
     */
    public function create()
    { 
        $this->data['employer_id'] = EmployerDetail::getNextEmployerId();
        $this->data['industries'] = Industry::pluck('name','id');
        $this->data['active_sub_menue'] = 'employer';
        return view('employers.create', $this->data);
    }

    private function store_branch_offices($employer_id)
    {   
        $data = request()->all();
        $insert_arr = [];

        foreach ($data as $input_name => $location_id)
        {   
            if(strpos($input_name, "branch_office_") === 0)
            {   
                $arr = [];

                $arr['employer_id']  = $employer_id;
                $arr['location_id']  = $location_id;

                $obj_loc = WorldLocation::select(['country_id','state_id','city_id'])->where(['id'=>$location_id,'status'=>'active'])->first();
                
                if($obj_loc->country_id)
                {
                    $arr['country_id'] = $obj_loc->country_id;
                }

                if($obj_loc->state_id)
                {
                    $arr['state_id'] = $obj_loc->state_id;
                }

                if($obj_loc->city_id)
                {
                    $arr['city_id'] = $obj_loc->city_id;
                }

                $insert_arr[] = $arr;
            }
        }
        Employer_branch_office::where('employer_id',$employer_id)->delete();

        Employer_branch_office::insert($insert_arr);
    }

    /**
     * Store a new employer in the storage.
     *
     * @param App\Http\Requests\EmployersFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(EmployerFormRequest $request)
    {  
        try
        {    
            $data = $request->getData();

            $data['head_office_location_id'] = $data['head_office'];

            unset($data['head_office']);

            $data['slug'] = slug_url($data['company_name']);

            $data['logo'] = 'default.png';

            $file_extension = request()->file('logo')->getClientOriginalExtension();
            $file_name      = slug_url('logo-'.$data['company_name']).'.'.$file_extension;
             $path          = request()->file('logo')->storeAs('public/employer_logos',"$file_name");
            if($path)
            {
                $data['logo'] = $file_name;
            }

            $obj = EmployerDetail::create($data);

            if($obj->id)
            {
                $this->store_branch_offices($obj->id);
            }

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('employers.employer.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified employer.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $this->data['employer'] = EmployerDetail::with('industry')->findOrFail($id);
        $this->data['active_sub_menue'] = 'employer';
        return view('employers.show', $this->data);
    }

    

    /**
     * Show the form for editing the specified employer.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['industries'] = Industry::pluck('name','id');
        $this->data['employer'] = EmployerDetail::findOrFail($id);
        $this->data['active_sub_menue'] = 'employer';

        return view('employers.edit', $this->data);
    }

    /**
     * Update the specified employer in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\EmployersFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, EmployerFormRequest $request)
    {
        try
        {
            $data = $request->getData();

            $data['head_office_location_id'] = $data['head_office'];

            unset($data['head_office']);

            $data['slug'] = slug_url($data['company_name']);

            if(request()->get('password'))
            {
               $data['password'] =bcrypt($data['password']); 
            }
            else
            {
                unset($data['password']);
            }

            if(request()->has('logo'))
            {
                $file_extension = request()->file('logo')->getClientOriginalExtension();
                $file_name      = slug_url('logo-'.$data['company_name']).'.'.$file_extension;

                 $path          = request()->file('logo')->storeAs('public/employer_logos',"$file_name");
                if($path)
                {
                    $data['logo'] = $file_name;
                }
            }

            $employer = EmployerDetail::findOrFail($id);
            $employer->update($data);
            $this->store_branch_offices($id);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('employers.employer.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified employer from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {   
        try
        {   
            $employer = EmployerDetail::findOrFail($id);
            $employer->delete();

            Employer_branch_office::where('employer_id',$id)->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('employers.employer.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    public function list_associated_acc($company_id)
    {
        if(request()->ajax())
        {   
            $model = Employer::with(['my_location','currency','timezone'])->where(['company_id'=>$company_id]);

            return datatables()->eloquent($model)
                        ->filter(function($q){

                            if(request()->has('name') && !empty(request()->get('name')))
                            {   
                                $q->where("name","like","%".request()->get('name')."%");
                            }

                            if(request()->has('email') && !empty(request()->get('email')))
                            {   
                                $q->where("email","like","%".request()->get('email')."%");
                            }

                            if(request()->has('mobile') && !empty(request()->get('mobile')))
                            {   
                                $q->where("mobile","like","%".request()->get('mobile')."%");
                            }

                            if(request()->has('status') && !empty(request()->get('status')))
                            {   
                                $q->where("status",request()->get('status'));
                            }

                        }, true)
                        ->setTransformer(new EmployerAssociatedAccountTransformer(new Employer))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'employer';
        $this->data['obj_emp'] = EmployerDetail::findOrFail($company_id);
        return view('employers.associated_accounts.index', $this->data);
    }

    public function create_associated_acc($company_id)
    {   
        $this->data['active_sub_menue'] = 'employer';

        $this->data['currencies'] = Currency::orderBy('name')->pluck('name','id');

        $this->data['time_zones'] = TimeZones::orderBy('name')->selectRaw("CONCAT(name,'(',text,')') AS name,id")->get();


        $this->data['obj_emp'] = EmployerDetail::findOrFail($company_id);
        return view('employers.associated_accounts.create', $this->data);
    }

    public function store_associated_acc($company_id)
    {   

        request()->validate([
            'email'   => "required|email|unique:employers,email,null,id,deleted_at,NULL",
            'name'              =>  'required|max:191',
            'contact_number'    =>  'required|numeric|digits_between:8,15|unique:employers,mobile,null,id,deleted_at,NULL',
            'location'          =>  'required|numeric',
            'currency'          =>  'required|numeric',
            'timezone'          =>  'required|numeric',
            'status'            =>  'required'
        ]);

        try
        {   
            $post = request()->all();

            $password = randomPassword();

            $insert_arr['company_id']       = $company_id;
            $insert_arr['name']             = $post['name'];
            $insert_arr['email']            = $post['email'];
            $insert_arr['mobile']           = $post['contact_number'];
            $insert_arr['password']         = bcrypt($password);
            $insert_arr['location_id']      = $post['location'];
            $insert_arr['time_zone_id']     = $post['timezone'];
            $insert_arr['currency_id']      = $post['currency'];
            $insert_arr['status']           = $post['status'];

            $obj = Employer::create($insert_arr);

            if($obj->id > 0)
            {
                $details['email']       = $post['email'];
                $details['password']    = $password;
                $details['url'] = route('employer.login');

                dispatch(new \App\Jobs\EmployerSignupEmailJob($details));

                request()->session()->flash('success_notify','Record successfully created');
            }
            else
            {
                request()->session()->flash('error',SERVER_ERR_MSG);
            }
        }
        catch(Exception $e)
        {
            request()->session()->flash('error',SERVER_ERR_MSG);
        }

        return redirect()->route('admin.list_associated_acc',[$company_id]);
    }

    public function edit_associated_acc($user_id)
    {   
        $this->data['active_sub_menue'] = 'employer';

        $this->data['currencies'] = Currency::orderBy('name')->pluck('name','id');

        $this->data['time_zones'] = TimeZones::orderBy('name')->selectRaw("CONCAT(name,'(',text,')') AS name,id")->get();

        $obj_user = Employer::findOrFail($user_id);
        
        $this->data['obj_user'] = $obj_user; 

        $this->data['obj_emp'] = EmployerDetail::findOrFail($obj_user->company_id);
        
        return view('employers.associated_accounts.edit', $this->data);
    }

    public function update_associated_acc($user_id)
    {   
        //dd(request()->all());
        $obj_user = Employer::findOrFail($user_id);

        request()->validate([
            'contact_number'   => "required|unique:employers,mobile,$user_id,id,deleted_at,NULL",
            'name'              =>  'required|max:191',
            'location'          =>  'required|numeric',
            'currency'          =>  'required|numeric',
            'timezone'          =>  'required|numeric',
            'status'            =>  'required'
        ]);

        try
        {   
            $post = request()->all();

            $obj_user->name = $post['name'];
            $obj_user->mobile = $post['contact_number'];
            $obj_user->location_id = $post['location'];
            $obj_user->time_zone_id = $post['timezone'];
            $obj_user->currency_id = $post['currency'];
            $obj_user->status = $post['status'];

            if(request()->get('password'))
            {
               $obj_user->password = bcrypt($post['password']); 
            }
            
            if($obj_user->save())
            {
                request()->session()->flash('success_notify','Record successfully updated');
            }
            else
            {
                request()->session()->flash('error',SERVER_ERR_MSG);
            }
        }
        catch(Exception $e)
        {
            request()->session()->flash('error',SERVER_ERR_MSG);
        }
        
        return redirect()->route('admin.list_associated_acc',[$obj_user->company_id]);

    }

    public function delete_associated_acc($user_id)
    {
        $obj_user = Employer::findOrFail($user_id);
        try
        {
            $obj_user->delete();

            Employer_branch_office::where('employer_id',$id)->delete();

            if($obj_user->delete())
            {
                request()->session()->flash('success_notify','Record successfully deleted');
            }
        }
        catch(Exception $e)
        {
            request()->session()->flash('error',SERVER_ERR_MSG);
        }

        return redirect()->route('admin.list_associated_acc',[$obj_user->company_id]);
    }
}
