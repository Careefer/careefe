<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Transformers\EmployerDetailTransformer;
use Illuminate\Http\Request;
use App\Models\EmployerDetail;
use Exception;

class CompanyController extends Controller
{

	private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-companies';
    }

    public function index()
    {

        if(request()->ajax())
        {   
            
			
			$model = EmployerDetail::query();
			
             $obj = datatables()->eloquent($model)
						 ->filter(function($query){

                        if(request()->has('company_name') && !empty(request('company_name')))
                        {   
                            $query->where("company_name","like","%".request('company_name')."%");
                        }

                        if(request()->has('website_url') && !empty(request('website_url')))
                        {       
                            $query->where("website_url",request('website_url'));
                        }

                        if(request()->has('created_at') && !empty(request('created_at')))
                        {       
                            $created_at = get_date_db_format(request('created_at'));

                            $query->where("created_at","like","%$created_at%");
                        }

                    })->setTransformer(new EmployerDetailTransformer(new EmployerDetail))->toJson();

             return $obj;            
        }
        $this->data['active_sub_menue'] = 'listing';
        return view('companies.index', $this->data);
    }

    public function make_featured($id)
    {
        try
        {
            $employer_detail = EmployerDetail::findOrFail($id);
            $val = '';
            if($employer_detail->is_featured == 'yes'){
                $employer_detail->is_featured = 'no';
                $val = 'Unfeatured';
            }else{
                $employer_detail->is_featured = 'yes';
                $val = 'featured';
            }

            
            $employer_detail->save();
            return redirect()->route('employers.employer.index')
                    ->with('success', 'Company has been made '. $val .' successfully .'); 
        }
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

}
