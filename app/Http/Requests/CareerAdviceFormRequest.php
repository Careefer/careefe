<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerAdviceFormRequest extends FormRequest
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
        $edit_id = request()->route('career_advice');

        $rules = [
            'category_id' => 'required|integer',
            'title'       => 'required|max:191|unique:career_advices,title,'.$edit_id,
            'slug'        => 'required|max:191',
            'image'       => 'required|mimes:png,jpg,jpeg,gif,svg,mp4,bmp,3gp,ogg|max:5120',
            'content'     => 'required',
            'status'      => 'required'
        ];

        if(request()->get('image'))
        {
            unset($rules['image']);
        }

        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['category_id', 'title', 'slug', 'content', 'status', 'meta_title', 'meta_keyword', 'meta_desc']);
        return $data;
    }
}
