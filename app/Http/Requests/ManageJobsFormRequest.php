<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageJobsFormRequest extends FormRequest
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
        $post = request()->all(); 

        $rules = [
            'company_name'      => 'required',
            'position'          => 'required|numeric|digits_between:1,10',
            'add_job_country'   => 'required|numeric|digits_between:1,10',
            'state_id'          => 'required',
            'city_id'           => 'required',
            'min_experience'    => 'required|numeric|digits_between:1,2|gt:0',
            'max_experience'    => "required|numeric|digits_between:1,2|gte:".$post['min_experience'],
            'vacancies'         => 'required|numeric',
            'add_job_skills'    => 'required',
            'min_salary'        => 'required|numeric|digits_between:1,7|gt:0',
            'max_salary'        => 'required|numeric|digits_between:1,7|gte:'.$post['min_salary'],
            'job_summary'       => 'required|max:500',
            'job_description'   => 'required|max:500',
            'functional_area'   => 'required',
            'educations'        => 'required',
            'work_type'         => 'required|numeric',
            'commission_type'   => 'required',
            'commission_amt'    => 'required|numeric',
            'referral_bonus_amt' => 'required',
            'specialist_bonus_amt' => 'required',
            //'f_area'             => 'required',
            //'primary_specialist'             => 'required',
            //'secondary_specialist'             => 'required',
            'job_type'              => 'required',
            
        ];

        return $rules;
    }

    public function messages()
    {
        return [

            "state_id.required" =>  "The state field is required",
            "city_id.required"  =>  "The city field is required",
            //"f_area.required"   =>  "The Functional area is required"

        ];
    }
}
