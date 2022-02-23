<?php

namespace App\Http\Controllers\SpecialistApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Bank_format, Country, Bank_format_countries, specialistBankDetail, Bank_format_field};

class PaymentController extends Controller
{
    protected $viewBasePath;
    protected $data;

    function __construct(){
		$this->bankFormatCountry = new Bank_format_countries();
		$this->specialistBankDetail =  new specialistBankDetail();
		$this->bankFormatField = new Bank_format_field();
		$this->viewBasePath = 'specialistApp.payment';
	}

	public function bankDetail()
	{
		$my_id = my_id();

		if(request()->input('country_id') && request()->input('country_id') !== '')
		{
			$bankformat= $this->bankFormatCountry->getbankFormat(request()->input('country_id'));
			$this->data['bank_format_fields'] = (@$bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
			$this->data['countryId'] = request()->input('country_id');
		}else
		{
			$dataField = $this->specialistBankDetail::where('specialist_id', $my_id)->first(['country_id']);

			if(!empty($dataField)){
				$bankformat= $this->bankFormatCountry->getbankFormat($dataField['country_id']);
				$this->data['bank_format_fields'] = (@$bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
				$this->data['countryId'] = $dataField['country_id'];	
			}else{
				$bankformat= $this->bankFormatCountry->getbankFormat(1);
				$this->data['bank_format_fields'] = (@$bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
				$this->data['countryId'] = 1;	
			}
		}
		$this->data['type'] = 'bank-detail';
		$this->data['countries'] = Country::pluck('name','id');
		return view($this->viewBasePath.'.list', $this->data);
	}

	public function updateBankDetail()
	{
		$inputData = request()->all();
		$my_id = my_id();
		$bankformat = $this->bankFormatCountry->getbankFormat($inputData['country_id']);
		$bankformatdata = ($bankformat->bank_format->bank_format_fields) ? $bankformat->bank_format->bank_format_fields : [];
		$this->specialistBankDetail->where('specialist_id', $my_id)->delete();
		if(count($bankformatdata) > 0 ) 
		{
			foreach ($bankformatdata as $key => $value)
			{
				if(array_key_exists($value->name, $inputData)){
					$data['bank_format_id'] = $value->bank_format_id;
					$data['bank_format_field_id'] = $value->id;
					$data['name'] = $value->name;
					$data['label'] = $value->label;
					$data['value'] = $inputData[$value->name];
					$data['specialist_id'] = $my_id;
					$data['country_id'] = $inputData['country_id'];
					$this->specialistBankDetail::create($data);
				}
			}
		}
		return back()->withInput()->with('success', 'Bank Detail Updated Successfully');
	}
}
