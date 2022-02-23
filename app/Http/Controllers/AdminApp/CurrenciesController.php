<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrenciesFormRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Transformers\CurrencyTransformer;
use App\Models\Country;
use App\Models\Currency;
use Exception;


class CurrenciesController extends Controller
{

    
    private $data = [];
     public function __construct()
    {
        $this->data['active_menue'] = 'manage-currency';
    }
    
    /**
     * Display a listing of the currencies.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {       
        if(request()->ajax())
        {       
            $model = currency::with('country');

            if(request()->has('country') && !empty(request()->get('country')))
            {   
                $model = $model->whereHas('country',function($q){
                    
                    $q->where("name","like","%".request()->get('country')."%");
                });
            }
            
            $obj = Datatables::eloquent($model)
                    ->filter(function($query)
            {
                if(request()->has('currency_name') && !empty(request()->get('currency_name')))
                {   
                    $query->where("name","like","%".request()->get('currency_name')."%");
                }

                if(request()->has('code') && !empty(request()->get('code')))
                {   
                    $query->where("iso_code","like","%".request()->get('code')."%");
                }

                if(request()->has('status') && !empty(request()->get('status')))
                {   
                    $query->where("status",request()->get('status'));
                }

                if(request()->has('date') && !empty(request()->get('date')))
                {       
                    $date = get_date_db_format(request()->get('date'));
                    $query->where("created_at","like","%".$date."%");
                }

                
            })->setTransformer(new CurrencyTransformer(new currency))
                ->toJson();
            return $obj;
        }

        $this->data['active_menue']     = 'manage-currency';
        $this->data['active_sub_menue'] = 'currencies';
        return view('currencies.index', $this->data);
    }

    /**
     * Show the form for creating a new currency.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $countries = Country::pluck('name','id')->all();
        $this->data['active_menue']     = 'manage-currency';
        $this->data['active_sub_menue'] = 'currencies';
        $this->data['countries'] = $countries;
        return view('currencies.create', $this->data);
    }

    /**
     * Store a new currency in the storage.
     *
     * @param App\Http\Requests\CurrenciesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(CurrenciesFormRequest $request)
    {   
        try
        {
            $data = $request->all();
            Currency::create($data);
            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('currencies.currency.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified currency.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $currency = Currency::with('country')->findOrFail($id);
        $this->data['active_menue']     = 'manage-currency';
        $this->data['active_sub_menue'] = 'currencies';
        $this->data['currency']     = $currency;
        return view('currencies.show', $this->data);
    }

    /**
     * Show the form for editing the specified currency.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $currency = Currency::findOrFail($id);
        
        $countries = Country::pluck('name','id')->all();
        $this->data['active_menue']     = 'manage-currency';
        $this->data['active_sub_menue'] = 'currencies';
        $this->data['currency']            = $currency;
        $this->data['countries']            = $countries;
        return view('currencies.edit', $this->data);
    }

    /**
     * Update the specified currency in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\CurrenciesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, CurrenciesFormRequest $request)
    {
        try
        {
            $data = $request->getData();
            
            $currency = Currency::findOrFail($id);
            $currency->update($data);
            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('currencies.currency.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified currency from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $currency = Currency::findOrFail($id);
            $currency->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('currencies.currency.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

}
