<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyConversionFormRequest extends FormRequest
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
        $rules = [
            'iso_code'  => 'required|max:191',
            'usd_value' => 'required|numeric|min:1'
            
        ];
        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['iso_code', 'usd_value']);

        return $data;
    }
}
