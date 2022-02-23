<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerFormRequest extends FormRequest
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
            'title'   => 'required',
            //'link'    => 'required',
            'content' => 'required',
            'status'  => 'required'
        ];
        if($this->hasFile('image')) 
        {
              $rules['image']  = 'mimes:jpg,jpeg,png,bmp,tiff,mp4,3gp,avi,mov,webm,ogg,flv';
        }

        return $rules;
    }

    public function getData()
    {
        $data = $this->only(['title', 'link', 'content', 'status']);

        return $data;
    }
}
