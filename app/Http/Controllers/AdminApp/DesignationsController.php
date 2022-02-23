<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationsFormRequest;
use App\Transformers\DesignationTransformer;
use App\Models\Designation;
use Exception;


class DesignationsController extends Controller
{

    
    private $data = [];

    /**
     * Display a listing of the designations.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        if(request()->ajax())
        {   
            $model = designation::query();

            return datatables()->eloquent($model)
                        ->filter(function($query){

                            if(request()->has('name') && !empty(request('name')))
                            {   
                                $query->where("name","like","%".request('name')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $query->where("status",request('status'));
                            }

                            if(request()->has('date') && !empty(request()->get('date')))
                            {       
                                $date = get_date_db_format(request()->get('date'));
                                $query->where("created_at","like","%".$date."%");
                            }

                        })
                        ->setTransformer(new DesignationTransformer(new Designation))
                        ->toJson();
        }
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'designation';
        return view('designations.index', $this->data);
    }

    /**
     * Show the form for creating a new designation.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'designation';
        return view('designations.create', $this->data);
    }

    /**
     * Store a new designation in the storage.
     *
     * @param App\Http\Requests\DesignationsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(DesignationsFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            designation::create($data);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('designations.designation.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified designation.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $designation = designation::findOrFail($id);
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'designation';
        $this->data['designation']     = $designation;
        return view('designations.show',  $this->data);
    }

    /**
     * Show the form for editing the specified designation.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $designation = designation::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'designation';
        $this->data['designation']            = $designation;
        return view('designations.edit', $this->data);
    }

    /**
     * Update the specified designation in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\DesignationsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, DesignationsFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            
            $designation = designation::findOrFail($id);
            $designation->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('designations.designation.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified designation from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $designation = designation::findOrFail($id);
            $designation->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('designations.designation.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }



}
