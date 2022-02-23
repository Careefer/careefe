<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployerDetail;
use App\Models\Industry;

class CompaniesController extends Controller
{	
	private $data = [];

    public function listing($industry_slug = null , Request $req)
    {	
    	$obj_company = EmployerDetail::orderBy('company_name');

    	if($industry_slug)
    	{	
    		$obj_industry = Industry::where(['slug'=>$industry_slug])->firstOrFail();
    		$obj_company->where(['industry_id'=>$obj_industry->id]);
    	}

    	// letter filter
    	if($req->get('letter'))
    	{
    		$letter = $req->get('letter');
    		if($letter !== '0_9')
    		{
    			$obj_company->where('company_name','like',"$letter%");
    		}
    	}

    	// keyword search
    	if($req->get('keyword'))
    	{
    		$keyword = $req->get('keyword');

    		$obj_company->where('company_name','like',"%$keyword%");
    	}

    	$obj_company->where(['status'=>'active']);

    	$this->data['companies'] = $obj_company->paginate(20);

    	if($req->ajax())
    	{
    		return view('webApp.companies.load_listing_html',$this->data);
    	}

    	$this->data['industries'] = Industry::orderBy('name')->where(['status'=>'active'])->get();

    	$this->data['active_industry'] = $industry_slug;

    	return view('webApp.companies.listing',$this->data);
    }

    public function detail($company_slug)
    {	
    	$this->data['obj_company'] = EmployerDetail::where(['slug'=>$company_slug])->firstOrFail();

    	return view('webApp.companies.detail',$this->data);
    } 
}
