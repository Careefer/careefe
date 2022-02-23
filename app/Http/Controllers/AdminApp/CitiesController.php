<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CitiesFormRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Exception;
use App\Transformers\CityTransformer;
use Illuminate\Http\Request;


class CitiesController extends Controller
{

    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-location';
    }
    /**
     * Display a listing of the cities.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = city::query();

            if(request()->has('country') && !empty(request('country')))
            {   
                $model = $model->whereHas('country',function($qry){
                    $qry->where("name","like","%".request('country')."%");

                });
            }

            if(request()->has('state') && !empty(request('state')))
            {   
                $model = $model->whereHas('state',function($qry){
                    $qry->where("name","like","%".request('state')."%");

                });
            }

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
                        ->setTransformer(new CityTransformer(new city))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'city';
        return view('cities.index',$this->data);
    }

    /**
     * Show the form for creating a new city.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('name','id')->all();
        
        $this->data['active_sub_menue'] = 'city';
        $this->data['countries'] = $countries;
        return view('cities.create', $this->data);
    }

    /**
     * Store a new city in the storage.
     *
     * @param App\Http\Requests\CitiesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(CitiesFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            
            City::create($data);

            request()->session()->flash('success','Record created successfully.');

            return redirect()->route('cities.city.index');
        } catch (Exception $exception) {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified city.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $city = City::with('country','state')->findOrFail($id);

        return view('cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified city.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['city']      = City::findOrFail($id);
        $this->data['countries'] = Country::pluck('name','id')->all();
        $this->data['states']    = State::where('country_id',$this->data['city']->country_id)->pluck('name','id')->all();

        $this->data['active_sub_menue'] = 'city';

        return view('cities.edit', $this->data);
    }

    /**
     * Update the specified city in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\CitiesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, CitiesFormRequest $request)
    {
        try
        {
            $data = $request->getData();
            
            $city = City::findOrFail($id);
            $city->update($data);
            request()->session()->flash('success','Record updated successfully.');
            
            return redirect()->route('cities.city.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified city from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $city = City::findOrFail($id);
            $city->delete();

            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('cities.city.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }


    public function load_state($country_id)
    {
        $states = State::orderBy('name','asc')->where('country_id',$country_id)->get();

        $html = '';
        if($states->count())
        {
            foreach ($states as $key => $value)
            {
                $html.='<option value="'.$value->id.'">'.$value->name.'</option>';
            }
        }
        else
        {
            $html.='<option value="">No state found</option>';
        }

        echo $html;
    }

    public function cities(Request $request) 
    {    
        $cityName = $request->term;
        $cities = City::where('name','LIKE','%'.$cityName.'%')->get();
        
        $data=array();
        foreach ($cities as $city) {
                $data[] = $city->name;
        }
       return $data;      
    }
}
