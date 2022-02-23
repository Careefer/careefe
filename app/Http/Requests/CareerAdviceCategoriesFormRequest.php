<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerAdviceCategoriesFormRequest extends FormRequest
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
        $edit_id = request()->route('careerAdviceCategory');

        $rules = [
            'title'  => "required|unique:career_advice_categories,title,$edit_id,id,deleted_at,NULL",
            'slug' => 'required',
            'status' => 'required'
        ];

        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['title', 'slug', 'status', 'meta_title', 'meta_keyword', 'meta_desc']);

        return $data;
    }
}
