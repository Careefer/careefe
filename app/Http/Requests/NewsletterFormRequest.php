<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterFormRequest extends FormRequest
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
            'title'          => 'required|max:191',
            'user_group'     => 'required|max:191',
            'subject'        => 'required|max:191',
            /*'attachments'    => 'required',*/
            'content'        => 'required',
        ];

        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['title', 'user_group', 'subject', 'content']);
    
        return $data;
    }
}
