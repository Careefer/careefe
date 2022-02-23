<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogsFormRequest;
use App\Transformers\BlogsTransformer;
use App\Models\BlogCategory;
use App\Models\Blog;
use Exception;
use Image;
use Yajra\DataTables\Facades\DataTables;



class BlogsController extends Controller
{   
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-blogs';
    }

    /**
     * Display a listing of the blogs.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = blog::with(['category']);

            if(request()->has('category') && !empty(request()->get('category')))
            {   
                $model = $model->whereHas('category',function($query){
                    $query->where("title","like","%".request()->get('category')."%");
                });
            }

            //$model = $model->orderBy('id','desc');

             return Datatables::eloquent($model)
                        ->filter(function($query){

                            if(request()->has('title') && !empty(request()->get('title')))
                            {   
                                $query->where("title","like","%".request()->get('title')."%");
                            }

                            if(request()->has('status') && !empty(request()->get('status')))
                            {   
                                $query->where("status",request()->get('status'));
                            }

                            if(request()->has('created_at') && !empty(request('created_at')))
                            {       
                                $created_at = get_date_db_format(request('created_at'));

                                $query->where("created_at","like","%$created_at%");
                            }

                        }, true)
                        ->setTransformer(new BlogsTransformer(new blog))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'blogs';
        return view('blogs.index',$this->data);
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $categories = BlogCategory::pluck('title','id')->all();
        
        $this->data['active_sub_menue'] = 'blogs';
        $this->data['categories']       = $categories;

        return view('blogs.create', $this->data);
    }

    /**
     * Store a new blog in the storage.
     *
     * @param App\Http\Requests\BlogsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(BlogsFormRequest $request)
    {
        try{
            
            $data = $request->getData();

            if($request->hasFile('image')) 
            {
            
            $file_extension = $request->file('image')->extension();
            $image = $request->file('image');
            $data['image'] = time().'.'.$image->extension();

            $video_extension = array("mp4", "3gp", "avi", "mov" , "webm" , "ogg" , "flv");
            if(in_array($file_extension, $video_extension))
              {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $path = public_path().'/storage/blog_images';
                $file->move($path, $data['image']);

                $data['type'] = "video";
              }
            else
              {
                $image = $request->file('image');
                $data['image'] = time().'.'.$image->extension();
                
                $destinationPath = public_path('storage/blog_images/thumbnail_image');
                $img = Image::make($image->path());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$data['image']);
                
                $destinationPath = public_path('/storage/blog_images');
                $image->move($destinationPath, $data['image']);

                $data['type'] = "image";
             
              }
         
            }

            Blog::create($data);
            return redirect()->route('blogs.blog.index')
                ->with('success', 'Blog has been added successfully .');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified blog.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $blog = Blog::with('category')->findOrFail($id);

        $this->data['active_sub_menue'] = 'blogs';
        $this->data['blog']       = $blog;

        return view('blogs.show', $this->data);
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {   
        $blog = Blog::findOrFail($id);

        $categories = BlogCategory::pluck('title','id')->all();

        $this->data['active_sub_menue'] = 'blogs';
        $this->data['blog']             = $blog;
        $this->data['categories']       = $categories;

        return view('blogs.edit', $this->data);
    }

    /**
     * Update the specified blog in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\BlogsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, BlogsFormRequest $request)
    {

        try
        { 
            $data = $request->getData();
            
            $blog = Blog::findOrFail($id);

           if($request->hasFile('image')) 
            {
                $file_extension = $request->file('image')->extension();
                $image = $request->file('image');
                $data['image'] = time().'.'.$image->extension();

                $video_extension = array("mp4", "3gp", "avi", "mov" , "webm" , "ogg" , "flv");
                if(in_array($file_extension, $video_extension))
                  {
                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $path = public_path().'/storage/blog_images';
                    $file->move($path, $data['image']);
                    
                    $data['type'] = "video";
                   
                  }
                 else
                  {
                    $image = $request->file('image');
                    $data['image'] = time().'.'.$image->extension();
                    
                    $destinationPath = public_path('storage/blog_images/thumbnail_image');
                    $img = Image::make($image->path());
                    $img->resize(100, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$data['image']);
                    
                    $destinationPath = public_path('/storage/blog_images');
                    $image->move($destinationPath, $data['image']);

                    $data['type'] = "image";
                 
                  }
            }

            $blog->update($data);
            return redirect()->route('blogs.blog.index')
                ->with('success', 'Blog has been updated successfully .');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified blog from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();
            return redirect()->route('blogs.blog.index')
                ->with('success', 'Blog has been deleted successfully.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
