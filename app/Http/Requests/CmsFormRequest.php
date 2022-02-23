<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CmsFormRequest extends FormRequest
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
        $edit_id = request()->route('manage_cms_page');

        $rules = [
            'title'       => 'required|max:191|unique:cms_pages,title,'.$edit_id,
            'slug'        => 'required|max:191',
            'content'     => 'required',
            'status'      => 'required'
        ];

        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['title', 'slug', 'content', 'status', 'meta_title', 'meta_keyword', 'meta_desc']);

        return $data;
    }
}
