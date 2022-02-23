<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CurrenciesFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $edit_id = request()->route('currency');

        $rules = [
            'name'       => 'required|max:191|unique:currencies,name,'.$edit_id,
            'iso_code'   => 'required|max:191',
            'symbol'     => 'required|max:191',
            'country_id' => 'required|integer',
            'status'     => 'required',
        ];

        return $rules;
    }
    
    /**
     * Get the request's data from the request.
     *
     * 
     * @return array
     */
    public function getData()
    {
        $data = $this->only(['name', 'iso_code', 'symbol', 'country_id', 'status']);

        return $data;
    }

}