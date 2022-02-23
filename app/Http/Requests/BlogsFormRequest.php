<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class BlogsFormRequest extends FormRequest
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
        $edit_id = request()->route('blog');

        $rules = [
            'category_id' => 'required|integer',
            'title'       => 'required|max:191|unique:blogs,title,'.$edit_id,
            'slug'        => 'required|max:191',
            'image'       => 'required|mimes:png,jpg,jpeg,gif,svg,mp4,bmp,3gp,ogg|max:5120',
            'content'     => 'required',
            'status'      => 'required',
        ];

        if(request()->get('image'))
        {
            unset($rules['image']);
        }

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
        $data = $this->only(['category_id', 'title', 'slug', 'content', 'status', 'meta_title', 'meta_keyword', 'meta_desc']);
        /*if ($this->has('custom_delete_image'))
        {
            $data['image'] = null;
        }*/

        /*if ($this->hasFile('image'))
        {
            $data['image'] = $this->moveFile($this->file('image'));
        }*/

        return $data;
    }
  
    /**
     * Moves the attached file to the server.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if(!$file->isValid())
        {
            return '';
        }

        $path = config('laravel-code-generator.files_upload_path', 'blog_images');

        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }
}