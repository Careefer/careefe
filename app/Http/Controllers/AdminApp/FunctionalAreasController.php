<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\FunctionalAreasFormRequest;
use App\Transformers\FunctionalAreaTransformer;
use App\Models\FunctionalArea;
use Exception;

class FunctionalAreasController extends Controller
{    
    private $data = [];

    public function __construct()
    {   
        $this->data['active_menue'] = 'manage-job-attribute';
    }
    /**
     * Display a listing of the functional areas.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = FunctionalArea::query();

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
                        ->setTransformer(new FunctionalAreaTransformer(new FunctionalArea))
                        ->toJson();
        }
        $this->data['active_sub_menue'] = 'functional-area';
        $this->data['active_menue'] = 'manage-job-attribute';
        return view('functional_areas.index', $this->data);
    }

    /**
     * Show the form for creating a new functional area.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        $this->data['active_sub_menue'] = 'functional-area';
        return view('functional_areas.create',$this->data);
    }

    /**
     * Store a new functional area in the storage.
     *
     * @param App\Http\Requests\FunctionalAreasFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(FunctionalAreasFormRequest $request)
    {
        try 
        {   
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            FunctionalArea::create($data);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('functional_areas.functional_area.index');
        } 
        catch (Exception $exception) 
        {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified functional area.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $functionalArea = FunctionalArea::findOrFail($id);

        $this->data['active_sub_menue']     = 'functional-area';
        $this->data['functionalArea']       = $functionalArea;
        return view('functional_areas.show', $this->data);
    }

    /**
     * Show the form for editing the specified functional area.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $functionalArea = FunctionalArea::findOrFail($id);
        
        $this->data['active_sub_menue'] = 'functional-area';
        $this->data['functionalArea']   = $functionalArea;
        return view('functional_areas.edit',  $this->data);
    }

    /**
     * Update the specified functional area in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\FunctionalAreasFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, FunctionalAreasFormRequest $request)
    {
        try
        {
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            $functionalArea = FunctionalArea::findOrFail($id);
            $functionalArea->update($data);

            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('functional_areas.functional_area.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified functional area from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $functionalArea = FunctionalArea::findOrFail($id);
            $functionalArea->delete();
			
			request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('functional_areas.functional_area.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }



}
