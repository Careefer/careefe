<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faqtitle;

class FaqController extends Controller
{
    /**
     * faq list
     */
    public function index()
    {	
    	$faq = Faqtitle::where('status','active')->get();

    	return view('webApp.faq.index',compact('faq'));
    }
}
