<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyConversionFormRequest;
use App\Transformers\CurrencyConversionTransformer;
use App\Models\CurrencyConversion;
use App\Models\Currency;
use Exception;
use App\Imports\CurrencyRateConversionImport;
use Maatwebsite\Excel\Facades\Excel;

class CurrencyConversionController extends Controller
{

    private $data = [];
    public function __construct()
    {
        $this->data['active_menue'] = 'manage-currency';
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
         if(request()->ajax())
        {   
            $model = CurrencyConversion::query();

             $obj = datatables()->eloquent($model)
                                ->filter(function($query){

                            if(request()->has('iso_code') && !empty(request('iso_code')))
                            {   
                                $query->where("iso_code","like","%".request('iso_code')."%");
                            }

                            if(request()->has('usd_value') && !empty(request('usd_value')))
                            {       
                                $query->where("usd_value","like","%".request('usd_value')."%");
                            }

                            if(request()->has('created_at') && !empty(request('created_at')))
                            {       
                                $created_at = get_date_db_format(request('created_at'));

                                $query->where("created_at","like","%$created_at%");
                            }

                        })
                        ->setTransformer(new CurrencyConversionTransformer(new CurrencyConversion))
                        ->toJson();
            return $obj;
        }
        $this->data['active_menue']     = 'manage-currency';
        $this->data['active_sub_menue'] = 'currency-rate-conversion';
        return view('currency_rate_conversions.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currency_codes = Currency::pluck('iso_code')->all();
        $this->data['active_menue']     = 'manage-currency';
        $this->data['active_sub_menue'] = 'currency-rate-conversion';
        $this->data['currency_codes'] = $currency_codes;
        return view('currency_rate_conversions.create',  $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurrencyConversionFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();

            $iso_code = $data['iso_code'];
            
            CurrencyConversion::updateOrCreate(['iso_code'=>$iso_code],$data);

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('currency_rate_conversions.currency_rate_conversion.index');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency_conversion = CurrencyConversion::findOrFail($id);
        $currency_codes = Currency::pluck('iso_code')->all();
        $this->data['active_menue']       = 'manage-currency';
        $this->data['active_sub_menue']   = 'currency-rate-conversion';
        $this->data['currency_conversion'] = $currency_conversion;
        $this->data['currency_codes']      = $currency_codes;

        return view('currency_rate_conversions.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, CurrencyConversionFormRequest $request)
    {
         try
        { 
            $data = $request->getData();
            $iso_code = $data['iso_code'];
            //$currency_conversion = CurrencyConversion::findOrFail($id);
            CurrencyConversion::updateOrCreate(['iso_code' => $iso_code],$data);

            request()->session()->flash('success_notify','Record updated successfully.');

            return redirect()->route('currency_rate_conversions.currency_rate_conversion.index');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $CurrencyConversion = CurrencyConversion::findOrFail($id);
            $CurrencyConversion->delete();
            return redirect()->route('currency_rate_conversions.currency_rate_conversion.index')
                ->with('success', 'Currency rate has been deleted successfully.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

     public function import()
    {   
        if(request()->all())
        {  
                $file = request()->file('name');
                
                if(empty($file))
                { 
                    request()->session()->flash('error_notify','Please select file to import');
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
            
                Excel::import(new CurrencyRateConversionImport, request()->file('name'));

                request()->session()->flash('success_notify','Data imported successfully.');

            }
            catch(Exception $exception)
            {
                request()->session()->flash('error','Unexpected error occurred while trying to process your request.');
            }
            return redirect()->back();
        }

        $this->data['active_sub_menue'] = 'import-currency-rate-conversion';

        return view('currency_rate_conversions.import', $this->data);
    }


    /**
     * Download sample country csv file
     * 
     */
    public function download_sample_currency_rate_conversion_csv()
    {
        $file= public_path()."/import-currency-rate-conversion-sample-format.csv";

        $headers = [

                      'Content-Type' => 'application/csv',

                   ];

         
        return response()->download($file, 'sample.csv', $headers);
    }

}
