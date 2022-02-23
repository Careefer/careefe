<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class EducationFormRequest extends FormRequest
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
        $id = request()->get('edit_id');

        $rules = [
            'name'  => "required|max:191|unique:education,name,{$id},id,deleted_at,NULL",
            'status' => 'required',
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
        $data = $this->only(['name', 'status']);

        return $data;
    }

}