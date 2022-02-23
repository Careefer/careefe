<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkTypesFormRequest;
use App\Transformers\WorkTypeTransformer;
use App\Models\work_type;
use Exception;


class WorkTypesController extends Controller
{
    private $data = [];

    /**
     * Display a listing of the work types.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        if(request()->ajax())
        {   
            $model = work_type::query();

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
                        ->setTransformer(new WorkTypeTransformer(new work_type))
                        ->toJson();
        }
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'work-type';
        return view('work_types.index', $this->data);
    }

    /**
     * Show the form for creating a new work type.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'work-type';
        return view('work_types.create');
    }

    /**
     * Store a new work type in the storage.
     *
     * @param App\Http\Requests\WorkTypesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(WorkTypesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            work_type::create($data);
            
            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('work_types.work_type.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified work type.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $workType = work_type::findOrFail($id);
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'work-type';
        $this->data['workType']         = $workType;
        return view('work_types.show', $this->data);
    }

    /**
     * Show the form for editing the specified work type.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $workType = work_type::findOrFail($id);
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'work-type';
        $this->data['workType']         = $workType;

        return view('work_types.edit', $this->data);
    }

    /**
     * Update the specified work type in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\WorkTypesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, WorkTypesFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            
            $workType = work_type::findOrFail($id);
            $workType->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('work_types.work_type.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified work type from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $workType = work_type::findOrFail($id);
            $workType->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('work_types.work_type.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }



}
