<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\TimezonesFormRequest;
use App\Transformers\TimezoneTransformer;
use App\Models\TimeZones;
use Exception;


class TimezonesController extends Controller
{

    
    private $data = [];

    
    /**
     * Display a listing of the timezones.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = TimeZones::query();

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
                    ->setTransformer(new TimezoneTransformer(new TimeZones))
                    ->toJson();
        }
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'timezones';
        return view('timezones.index', $this->data);
    }

    /**
     * Show the form for creating a new timezone.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'timezones';
        
        return view('timezones.create', $this->data);
    }

    /**
     * Store a new timezone in the storage.
     *
     * @param App\Http\Requests\TimezonesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(TimezonesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            TimeZones::create($data);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('timezones.timezone.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified timezone.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $timezone = TimeZones::findOrFail($id);

        return view('timezones.show', compact('timezone'));
    }

    /**
     * Show the form for editing the specified timezone.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $timezone = TimeZones::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'timezones';
        $this->data['timezone']            = $timezone;
        return view('timezones.edit', $this->data);
    }

    /**
     * Update the specified timezone in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\TimezonesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, TimezonesFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            
            $timezone = TimeZones::findOrFail($id);
            $timezone->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('timezones.timezone.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified timezone from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $timezone = TimeZones::findOrFail($id);
            $timezone->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('timezones.timezone.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }
}
