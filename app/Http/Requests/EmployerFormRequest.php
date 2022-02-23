<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class EmployerFormRequest extends FormRequest
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
        $messages[] = '';
        
        if(request()->get('temp'))
        {
            request()->session()->put('total_branch_office',count(request()->get('temp')));
        }
        else
        {
            request()->session()->put('total_branch_office',1);
        }

        $id = request()->get('edit_id');

        $rules = [
            'employer_id' => 'required',
            'company_name'   => "required|unique:employer_detail,company_name,$id,id,deleted_at,NULL|max:191",
            'head_office' => 'required|min:1|max:255|nullable',
            'industry_id' => 'required',
            'size_of_company' => 'required|nullable',
            'website_url' => 'required|min:1|nullable',
            //'about_company' => 'required|min:1|nullable',
            'status' => "required|max:191",

        ];

        foreach (request()->get('temp') as $key => $value)
        {
            //$rules["branch_office_$key"] = "required|max:191"; 
        }
        if(request()->has('logo')){
            $rules["logo"] = "image|mimes:jpeg,png,jpg,gif,svg|max:1024|dimensions:max_width=300,max_height=300"; 
        }

        if($id && !request()->has('logo'))
        {
            unset($rules['logo']);
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [];
        
        if(request()->has('temp'))
        {   
            $total = count(request()->get('temp'));

            foreach (request()->get('temp') as $key => $value)
            {       
                $number = $key+1;
                
                $messages["branch_office_$key.required"] = "Branch office $number is required";

                $messages["branch_office_$key.max"] = "Branch office ".$number." can 191 characters"; 
            }
        }
        return $messages;
    }
    
    /**
     * Get the request's data from the request.
     *
     * 
     * @return array
     */
    public function getData()
    {   
        $data = $this->only(['employer_id', 'company_name' ,'head_office', 'branch_office', 'industry_id', 'size_of_company', 'website_url', 'about_company', 'status']);

        return $data;
    }
}