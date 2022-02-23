<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transformers\BankFormatTransformer;
use App\Models\Bank_format;
use App\Models\Country;
use App\Models\Bank_format_countries;
use Yajra\DataTables\Facades\DataTables;




class BankFormatController extends Controller
{	
    private $data = [];

	/**
	 * List of all bank formats
	 */
    public function index()
    {	
    	if(request()->ajax())
        {   
            $model  = Bank_format::query();

            $obj = Datatables::eloquent($model)
                    ->filter(function($query){

                        if(request()->has('name') && !empty(request('name')))
                        {   
                            $query->where("name","like","%".request('name')."%");
                        }

                        if(request()->has('updated_at') && !empty(request('updated_at')))
                        {       
                            $updated_at = get_date_db_format(request('updated_at'));

                            $query->where("updated_at","like","%$updated_at%");
                        }

                    })->setTransformer(new BankFormatTransformer(new Bank_format))
                        ->toJson();
                    
            return $obj;
        }

        $this->data['active_menue']     = 'bank-format';
    	return view('bank_formats.index');
    }

    /**
     * Edit bank format
     */
    public function edit($id)
    {	
    	$this->data['bank_format'] 	= Bank_format::findOrFail($id);
    	$this->data['countries'] 	= Country::pluck('name','id');
    	return view('bank_formats.edit',$this->data);
    }

    /**
     *Update bankformat
     */
    public function update($id)
    {	
        try
        {	
        	request()->validate([
        		'name'		=>	'required',
        		'countries' => 	'required'
        	]);

        	$obj = Bank_format::find($id);
            $obj->name = request()->get('name');
        	$obj->updated_at = now();
        	
        	if($obj->save())
        	{	
        		$insert_arr = [];
        		foreach (request()->get('countries') as $index => $country_id)
        		{
        			$insert_arr[] = ['bank_format_id'=>$id,'country_id'=>$country_id];
        		}

        		//delete existing
        		Bank_format_countries::where('bank_format_id',$id)->delete();

        		// insert new fresh
        		Bank_format_countries::insert($insert_arr);
        	}
        	
            request()->session()->flash('success','Record updated successfully.');
            return redirect()->route('bank_format.index');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }
}
