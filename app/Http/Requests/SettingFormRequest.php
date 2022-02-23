<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingFormRequest extends FormRequest
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
        $rules = [];

        if($this->has('site_title')  && $this->has('site_email')) 
        {
              $rules['site_title']  = 'required|max:255';
              $rules['site_email']  = 'required|email|max:255';
        }

        if($this->has('fb_url') && $this->has('twitter_url')  && $this->has('linkedin_url') && $this->has('google_plus') && $this->has('instagram_url') && $this->has('youtube_url') && $this->has('pinterest_url')) 
        {
              $rules['fb_url']       = 'required|max:255';
              $rules['twitter_url']  = 'required|max:255';
              $rules['linkedin_url'] = 'required|max:255';
              $rules['google_plus'] = 'required|max:255';
              $rules['instagram_url'] = 'required|max:255';
              $rules['youtube_url'] = 'required|max:255';
              $rules['pinterest_url'] = 'required|max:255';
        }

        if($this->has('copyright_content')) 
        {
              $rules['copyright_content'] = 'required|max:255';
              
        }
        
        return $rules;
    }
}
