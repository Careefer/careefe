<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class SpecialistsFormRequest extends FormRequest
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
    public function rules($id = null)
    {   
		$id = request()->get('edit_id');

        $rules = [
            'specialist_id'      => "required|unique:specialists,specialist_id,{$id},id,deleted_at,NULL",

            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => "required|unique:specialists,email,{$id},id,deleted_at,NULL",

            'password'          => 'required|between:6,15|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'confirm_password'  => 'required|same:password',
            'status'            => 'required',
            'location'          => 'required',
            'functional_areas' => 'required',
            'resume' => 'required|max:5120|mimes:doc,pdf,docx,zip'
        ];

        if($id && !request()->hasFile('resume'))
        {
            unset($rules['resume']);
        }
		
		if($id && !request()->get('password'))
        {
            unset($rules['password']);
            unset($rules['confirm_password']);  
        }

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
        $data = $this->only(['specialist_id', 'first_name', 'last_name', 'email', 'password', 'location', 'functional_areas', 'status']);

        return $data;
    }

}