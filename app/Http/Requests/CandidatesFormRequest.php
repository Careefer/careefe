<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CandidatesFormRequest extends FormRequest
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
            'candidate_id'      => "required|unique:candidates,candidate_id,{$id},id,deleted_at,NULL",

            'first_name'        => 'required',
            'last_name'         => 'required',
            'email'             => "required|unique:candidates,email,{$id},id,deleted_at,NULL",

            'password'          => 'required|between:6,15|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',

            'confirm_password'  => 'required|same:password',
            'status'            => 'required',
        ];

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
        $data = $this->only(['candidate_id', 'first_name', 'last_name', 'email', 'password', 'status']);

        return $data;
    }

}