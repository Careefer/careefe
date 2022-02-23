<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationFormRequest;
use App\Transformers\EducationTransformer;
use App\Models\Education;
use Exception;


class EducationController extends Controller
{
    private $data = [];

    /**
     * Display a listing of the education.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        if(request()->ajax())
        {   
            $model = education::query();

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
                    ->setTransformer(new EducationTransformer(new education))
                    ->toJson();
        }
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'education';
        return view('education.index', $this->data);
    }

    /**
     * Show the form for creating a new education.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'education';
        return view('education.create',$this->data);
    }

    /**
     * Store a new education in the storage.
     *
     * @param App\Http\Requests\EducationFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(EducationFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            Education::create($data);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('education.education.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified education.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $education = Education::findOrFail($id);
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'education';
        $this->data['education']     = $education;
        return view('education.show', $this->data);
    }

    /**
     * Show the form for editing the specified education.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $education = Education::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'education';
        $this->data['education']            = $education;
        return view('education.edit', $this->data);
    }

    /**
     * Update the specified education in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\EducationFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, EducationFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            $education = Education::findOrFail($id);
            $education->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('education.education.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified education from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $education = Education::findOrFail($id);
            $education->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('education.education.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }



}
