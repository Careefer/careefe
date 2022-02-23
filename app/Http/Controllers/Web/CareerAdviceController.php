<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerAdviceCategory;
use App\Models\CareerAdvice;


class CareerAdviceController extends Controller
{
    public function listing($slug = null)
    {

        $career_advices = CareerAdvice::orderBy('id','desc');
       
        if($slug)
        {
          $career_advice_category = CareerAdviceCategory::where(['slug'=>$slug])->firstOrFail();
          $career_advices->where(['category_id'=>$career_advice_category->id]); 

          $this->data['categories_name'] = $career_advice_category->title;
          
        }

        $career_advices->where(['status'=>'active']);
        $this->data['career_advices'] = $career_advices->take(4)->get();

        $this->data['categories'] = CareerAdviceCategory::with(['career_advice_by_category'])
                                    ->where(['status'=>'active','is_recommend'=>'no'])
                                    ->has('career_advice_by_category')
                                    ->orderBy('id','desc')
                                    ->get();
        
        //dd( $this->data['categories']);

        $this->data['recommend_categories'] = CareerAdviceCategory::with([
            'career_advice_by_category' => function ($query) {
            $query->orderBy('id', 'desc')->take(4);
            }])        
           ->where(['status'=>'active','is_recommend'=>'yes'])
           ->orderBy('id','desc')
           ->get(); 

        $this->data['active_cat_slug'] = $slug;
    	return view('webApp.career_advice.listing',$this->data);
    }

    public function detail($slug)
    {
        $this->data['career_advice_detail'] = CareerAdvice::with(['category'])->where(['slug'=>$slug])->firstOrFail();
        $category_id = $this->data['career_advice_detail']->category->id;

        $this->data['career_advices'] = CareerAdvice::where('category_id',$category_id)->where('slug','!=', $slug)->orderBy('id','desc')->take(4)->get();

        return view('webApp.career_advice.details',$this->data);
    }

    public function all_career_advices($slug = null,Request $req)
    {
        $career_advices = CareerAdvice::orderBy('id','desc');
       
        if($slug)
        {
          $career_advice_category = CareerAdviceCategory::where(['slug'=>$slug])->firstOrFail();
          $career_advices->where(['category_id'=>$career_advice_category->id]);
           
          $this->data['career_advice_category'] = $career_advice_category;

        }

        $career_advices->where(['status'=>'active']);
        $this->data['career_advices'] = $career_advices->paginate(10);

        if($req->ajax())
        {
            return view('webApp.career_advice.include_listing_html', $this->data);
        }

        $this->data['categories'] = CareerAdviceCategory::with(['career_advice_by_category'])
                                    ->where(['status'=>'active','is_recommend'=>'no'])
                                    ->has('career_advice_by_category')
                                    ->orderBy('id','desc')
                                    ->get();
         $this->data['active_cat_slug'] = $slug;                           
        return view('webApp.career_advice.all_career_advices', $this->data);
    }
}
