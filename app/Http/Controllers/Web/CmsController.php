<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;


class CmsController extends Controller
{
    public function page($page)
    {
        $pages = Cms::where(['slug'=>$page])->first();
        if($pages)
        {
    		return view('webApp.cms.cms',compact('pages'));
        }
        else{
        	abort(404,'Page not found');
        }
    }
 
}
