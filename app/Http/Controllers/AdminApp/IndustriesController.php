<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndustriesFormRequest;
use App\Transformers\IndustryTransformer;
use App\Models\Industry;
use Exception;


class IndustriesController extends Controller
{

    
    private $data = [];

    
    /**
     * Display a listing of the industries.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        if(request()->ajax())
        {   
            $model = industry::query();

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
                    ->setTransformer(new IndustryTransformer(new industry))
                    ->toJson();
        }
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'industries';
        return view('industries.index', $this->data);
    }

    /**
     * Show the form for creating a new industry.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'industries';
        
        return view('industries.create', $this->data);
    }

    /**
     * Store a new industry in the storage.
     *
     * @param App\Http\Requests\IndustriesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(IndustriesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            Industry::create($data);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('industries.industry.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified industry.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $industry = Industry::findOrFail($id);
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'industries';
        $this->data['industry']     = $industry;
        return view('industries.show', $this->data);
    }

    /**
     * Show the form for editing the specified industry.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $industry = Industry::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'industries';
        $this->data['industry']            = $industry;
        return view('industries.edit', $this->data);
    }

    /**
     * Update the specified industry in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\IndustriesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, IndustriesFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);

            $industry = Industry::findOrFail($id);
            $industry->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('industries.industry.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified industry from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $industry = Industry::findOrFail($id);
            $industry->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('industries.industry.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }



}
