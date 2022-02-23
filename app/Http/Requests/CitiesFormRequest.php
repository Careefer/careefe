<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CitiesFormRequest extends FormRequest
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
            'name'       => 'required',
            'country_id' => 'required',
            'state_id'   => 'required',
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
        $data = $this->only(['name', 'country_id', 'state_id', 'status']);

        return $data;
    }

}