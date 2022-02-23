<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateFormRequest extends FormRequest
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
            'title'       => 'required|max:191',
            'content'     => 'required',
            'status'      => 'required'
        ];
        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['title', 'content', 'status']);

        return $data;
    }
}
