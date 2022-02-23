<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;

class BlogsController extends Controller
{
    public function listing()
    {
    	$this->data['categories'] = BlogCategory::has('blogs_by_category')
           ->where(['status'=>'active','is_recommend'=>'no'])
           ->orderBy('id','desc')
           ->get();
  
	    

		$this->data['recommend_categories'] = BlogCategory::with([
				'blogs_by_category' => function ($query) {
		        $query->orderBy('id', 'desc')->take(3);
		    	}])        
		       ->where(['status'=>'active','is_recommend'=>'yes'])
		       ->orderBy('id','desc')
		       ->get();       

	    	return view('webApp.blog.listing', $this->data);
    }

    public function detail($slug)
    {
		
    	$this->data['blog_detail'] = Blog::has('category')->where(['slug'=>$slug])->firstOrFail();

    	$category_id = $this->data['blog_detail']->category->id;
 
    	$this->data['blogs'] = Blog::where('category_id',$category_id)->where('slug','!=', $slug)->orderBy('id','desc')->take(4)->get();


    	return view('webApp.blog.details',$this->data);
    }


    public function all_blogs($cat_slug = null , Request $req)
    {	
    	$blog_data = Blog::orderBy('id','desc');
    	$blog_data->where(['status'=>'active']);

    	if($cat_slug)
    	{	
    		$obj_cat = BlogCategory::where(['slug'=>$cat_slug])->firstOrFail();
    		$blog_data->where(['category_id'=>$obj_cat->id]);

            $this->data['blog_category'] = $obj_cat;
    	}

    	$this->data['blogs'] = $blog_data->paginate(10);

    	if($req->ajax())
    	{
    		return view('webApp.blog.include_listing_html', $this->data);
    	}

    	$this->data['blog_categories'] = BlogCategory::where(['status'=>'active'])->pluck('title','slug');

    	$this->data['active_cat_slug'] = $cat_slug;

    	return view('webApp.blog.all_blogs', $this->data);
    }

    
    
}
