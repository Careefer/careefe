<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountriesFormRequest;
use App\Models\Country;
use App\Models\TimeZones;
use Exception;
use App\Transformers\CountryTransformer;
use App\Imports\CountryImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    private $data = [];
    
    public function __construct()
    {
        $this->data['active_menue'] = 'manage-location';
    }
    /**
     * Display a listing of the countries.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = country::with('timezone');

            if(request()->has('timezone') && !empty(request('timezone')))
            {   
                $model = country::query()->whereHas('timezone',function($qry){
                    $qry->where("name","like","%".request('timezone')."%");
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
                        ->setTransformer(new CountryTransformer(new country))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'country';
        return view('countries.index',$this->data);
    }

    /**
     * Show the form for creating a new country.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['timezone'] = TimeZones::orderBy('id','desc')->get();
        $this->data['active_sub_menue'] = 'country';

        return view('countries.create',$this->data);
    }

    /**
     * Store a new country in the storage.
     *
     * @param App\Http\Requests\CountriesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(CountriesFormRequest $request)
    {
        try
        {
            $data = $request->getData();
            
            Country::create($data);
            
            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('countries.country.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified country.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $country = Country::findOrFail($id);

        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified country.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $this->data['timezone'] = TimeZones::orderBy('id','desc')->get();
        $this->data['country'] = Country::findOrFail($id);
        $this->data['active_sub_menue'] = 'country';
    
        return view('countries.edit', $this->data);
    }

    /**
     * Update the specified country in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\CountriesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, CountriesFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            
            $country = Country::findOrFail($id);
            $country->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('countries.country.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified country from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $country = Country::findOrFail($id);
            $country->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('countries.country.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * import country csv 
     * 
     * @return void
     */
    public function import()
    {   
        if(request()->all())
        {  
                $file = request()->file('name');
                
                if(empty($file))
                { 
                    request()->session()->flash('error','Please select file to import');
                    return redirect()->back();
                }
                
                $extension = $file->getClientOriginalExtension();

                if(!in_array(strtolower($extension), ['csv']))
                { 
                    request()->session()->flash('error','Please import only CSV file');
                    return redirect()->back();
                }

            try
            {   
                $file_name = request()->file('name')->getClientOriginalName();
            
                Excel::import(new CountryImport, request()->file('name'));

                request()->session()->flash('success','Data imported successfully.');

            }
            catch(Exception $exception)
            {
                request()->session()->flash('error','Unexpected error occurred while trying to process your request.');
            }
            return redirect()->back();
        }

        $this->data['active_sub_menue'] = 'import';

        return view('countries.import', $this->data);
    }


    /**
     * Download sample country csv file
     * 
     */
    public function download_sample_country_csv()
    {
        $file= public_path()."/import-country-sample-format.csv";

        $headers = [

                      'Content-Type' => 'application/csv',

                   ];

         
        return response()->download($file, 'sample.csv', $headers);
    }

    public function countries(Request $request) 
    {    
        $countryName = $request->term;
        $countries = Country::where('name','LIKE','%'.$countryName.'%')->get();
        
        $data=array();
        foreach ($countries as $country) {
                $data[] = $country->name;
        }
       return $data;      
    }



}
