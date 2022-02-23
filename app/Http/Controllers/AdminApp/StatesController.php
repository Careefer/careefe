<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatesFormRequest;
use App\Models\Country;
use App\Models\State;
use Exception;
use App\Transformers\StateTransformer;
use Illuminate\Http\Request;


class StatesController extends Controller
{    
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-location';
    }
    /**
     * Display a listing of the states.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = state::query()->whereHas('country',function($qry){

                if(request()->has('country') && !empty(request('country')))
                {   
                    $qry->where("name","like","%".request('country')."%");
                }
            });

            return datatables()->eloquent($model)
                        ->filter(function($q){

                            if(request()->has('name') && !empty(request('name')))
                            {   
                                $q->where("name","like","%".request('name')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $q->where("status",request('status'));
                            }

                            if(request()->has('created_at') && !empty(request('created_at')))
                            {       
                                $created_at = get_date_db_format(request('created_at'));

                                $q->where("created_at","like","%$created_at%");
                            }
                        })    
                        ->setTransformer(new StateTransformer(new state))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'state';
        return view('states.index',$this->data);
    }

    /**
     * Show the form for creating a new state.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['countries']       = Country::pluck('name','id')->all();
        $this->data['active_sub_menue'] = 'state';    
        
        return view('states.create', $this->data);
    }

    /**
     * Store a new state in the storage.
     *
     * @param App\Http\Requests\StatesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(StatesFormRequest $request)
    {
        try
        {
            $data = $request->getData();
            
            State::create($data);

            request()->session()->flash('success','Record created successfully.');

            return redirect()->route('states.state.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified state.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $state = State::with('country')->findOrFail($id);

        return view('states.show', compact('state'));
    }

    /**
     * Show the form for editing the specified state.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['state'] = State::findOrFail($id);
        $this->data['countries'] = Country::pluck('name','id')->all();

        $this->data['active_sub_menue'] = 'state';    
        return view('states.edit', $this->data);
    }

    /**
     * Update the specified state in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\StatesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, StatesFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            
            $state = State::findOrFail($id);
            $state->update($data);
            request()->session()->flash('success','Record updated successfully.');
            
            return redirect()->route('states.state.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified state from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $state = State::findOrFail($id);
            $state->delete();

            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('states.state.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    public function states(Request $request) 
    {    
        $stateName = $request->term;
        $states = State::where('name','LIKE','%'.$stateName.'%')->get();
        
        $data=array();
        foreach ($states as $state) {
                $data[] = $state->name;
        }
       return $data;      
    }

}
