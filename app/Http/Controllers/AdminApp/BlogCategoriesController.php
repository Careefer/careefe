<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoriesFormRequest;
use App\Transformers\BlogCategoryTransformer;
use App\Models\BlogCategory;
use Exception;
use App\Transformers\CommanTransformer;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoriesController extends Controller
{   
    private $data = [];
    /**
     * Display a listing of the blog categories.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {   
        if(request()->ajax())
        {   
            $model  = blogCategory::query();

            $obj = Datatables::eloquent($model)
                    ->filter(function($query){

                        if(request()->has('title') && !empty(request('title')))
                        {   
                            $query->where("title","like","%".request('title')."%");
                        }

                        if(request()->has('status') && !empty(request('status')))
                        {       
                            $query->where("status",request('status'));
                        }

                    })->setTransformer(new BlogCategoryTransformer(new blogCategory))
                        ->toJson();
                    
            return $obj;
        }

        $this->data['active_menue']     = 'manage-blogs';
        $this->data['active_sub_menue'] = 'category';
        return view('blog_categories.index',$this->data);
    }

    /**
     * Show the form for creating a new blog category.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {   
        $this->data['active_menue']     = 'manage-blogs';
        $this->data['active_sub_menue'] = 'category';
        return view('blog_categories.create',$this->data);
    }

    /**
     * Store a new blog category in the storage.
     *
     * @param App\Http\Requests\BlogCategoriesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(BlogCategoriesFormRequest $request)
    {
        try
        {    
            $data = $request->getData();
            
            BlogCategory::create($data);

            request()->session()->flash('success','Record created successfully.');

            return redirect()->route('blog_categories.blog_category.index')
                ->with('success_message', 'Blog Category was successfully added.');
        }
        catch (Exception $exception)
        {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified blog category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-blogs';
        $this->data['active_sub_menue'] = 'category';
        $this->data['blogCategory']     = $blogCategory;
        return view('blog_categories.show', $this->data);
    }

    /**
     * Show the form for editing the specified blog category.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-blogs';
        $this->data['active_sub_menue'] = 'category';
        $this->data['blogCategory']     = $blogCategory;

        return view('blog_categories.edit', $this->data);
    }

    /**
     * Update the specified blog category in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\BlogCategoriesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, BlogCategoriesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $blogCategory = BlogCategory::findOrFail($id);
            $blogCategory->update($data);
            request()->session()->flash('success','Record updated successfully.');
            return redirect()->route('blog_categories.blog_category.index')
                ->with('success_message', 'Blog Category was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified blog category from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $blogCategory = BlogCategory::findOrFail($id);
            $blogCategory->delete();

            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('blog_categories.blog_category.index')
                ->with('success_message', 'Blog Category was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
