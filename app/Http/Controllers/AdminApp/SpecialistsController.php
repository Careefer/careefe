<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialistsFormRequest;
use App\Models\FunctionalArea;
use App\Models\UserLocation;
use App\Specialist;
use Exception;
use App\Transformers\SpecialistTransformer;


class SpecialistsController extends Controller
{

    
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-users';
    }
    /**
     * Display a listing of the specialists.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        if(request()->ajax())
        {   
            $model = Specialist::with(['current_location.world_location']);

            // filter application location
            if(request()->has('location') && !empty(request()->get('location')))
            {  
                $model = $model->whereHas('current_location',function($q)
                {
                    $q->whereHas('world_location',function($q2)
                    {   
                        $q2->where("location","like","%".request()->get('location')."%");
                    });
                });
            }

            return datatables()->eloquent($model->latest())
                        ->filter(function($q){

                            if(request()->get('specialist_id') && !empty(request()->get('specialist_id')))
                            {
                                $q->where('specialist_id','like',"%".request('specialist_id')."%");
                            }

                            if(request()->get('name') && !empty(request()->get('name')))
                            {
                                $q->where('name','like',"%".request('name')."%");
                            }

                            if(request()->get('email') && !empty(request()->get('email')))
                            {
                                $q->where('email','like',"%".request('email')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $q->where("status",request('status'));
                            }

                        })
                        ->setTransformer(new SpecialistTransformer(new Specialist))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'specialist';
        return view('specialists.index',$this->data);
    }

    /**
     * Show the form for creating a new specialist.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['functionalAreas'] = FunctionalArea::pluck('name','id')->all();
        $this->data['specialist_id'] = Specialist::getNextId();
        
        $this->data['active_sub_menue'] = 'specialist';

        return view('specialists.create', $this->data);
    }

    /**
     * Store a new specialist in the storage.
     *
     * @param App\Http\Requests\SpecialistsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(SpecialistsFormRequest $request)
    {
        $data = $request->getData();

        try
        {   
            $location_id = $data['location'];

			$data['name'] = $data['first_name'].' '.$data['last_name'];

            $data['password'] = bcrypt($data['password']);

            if(isset($data['functional_areas']))
            {
                $data['functional_area_ids'] = implode(',',$data['functional_areas']);
                unset($data['functional_areas']);
                unset($data['location']);
            }

			if($request->file('resume')) 
            {   
				$file_extension = $request->file('resume')->extension();
				$resume = $request->file('resume');
				$data['resume'] = 'resume_'.time().'.'.$resume->extension();

				$resume_extensions = array("pdf", "doc", "docx","zip");
				if(in_array($file_extension, $resume_extensions))
				{
					$file = $request->file('resume');
					$filename = $file->getClientOriginalName();
					$path = public_path().'/storage/specialist/resume';
					$file->move($path, $data['resume']);
				}            
            }

			$obj = Specialist::create($data);

            $this->update_location($location_id,$obj->id);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('specialists.specialist.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified specialist.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $this->data['specialist'] = Specialist::findOrFail($id);

        $this->data['active_sub_menue'] = 'specialist';

        return view('specialists.show', $this->data);
    }

    /**
     * Show the form for editing the specified specialist.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['specialist'] = Specialist::findOrFail($id);
        $this->data['functionalAreas'] = FunctionalArea::pluck('name','id')->all();

        $this->data['active_sub_menue'] = 'specialist';

        return view('specialists.edit', $this->data);
    }

    /**
     * Update the specified specialist in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\SpecialistsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, SpecialistsFormRequest $request)
    {      
        try
        {
            $data = $request->getData();

            $location_id = $data['location'];
			
			if(request()->get('password'))
            {
               $data['password'] =bcrypt($data['password']); 
            }
            else
            {
                unset($data['password']);
            }

            if(isset($data['functional_areas']))
            {
                $data['functional_area_ids'] = implode(',',$data['functional_areas']);
                unset($data['functional_areas']);
                unset($data['location']);
            }

            $data['name'] = $data['first_name'].' '.$data['last_name'];

			if($request->hasFile('resume')) 
            {
				$file_extension = $request->file('resume')->extension();
				$resume = $request->file('resume');
				$data['resume'] = time().'.'.$resume->extension();

				$resume_extensions = array("pdf", "doc", "docx");
				if(in_array($file_extension, $resume_extensions))
				{
					$file = $request->file('resume');
					$filename = $file->getClientOriginalName();
					$path = public_path().'/storage/specialist/resume';
					$file->move($path, $data['resume']);
				}
            }
            
            $specialist = Specialist::findOrFail($id);
            $specialist->update($data);

            $this->update_location($location_id,$id);

            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('specialists.specialist.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified specialist from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $specialist = Specialist::findOrFail($id);
            $specialist->delete();

            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('specialists.specialist.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    public function update_location($location_id , $id)
    {   
        $obj_location = UserLocation::where(['user_id'=>$id,'user_type'=>'specialist','location_type'=>'current'])->first();

        if($obj_location)
        {   
            $obj_location->location_id = $location_id;
            $obj_location->save();
        }
        else
        {
            $obj_location = new UserLocation();
            $obj_location->user_id = $id;
            $obj_location->user_type = 'specialist';
            $obj_location->location_type = 'current';
            $obj_location->location_id = $location_id;
            $obj_location->save();
        }
    }
	
}
