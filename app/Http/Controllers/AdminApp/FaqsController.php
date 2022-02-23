<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Faqtitle;
use Exception;
use App\Transformers\FaqTransformer;
use Illuminate\Http\Request;
use Validator;


class FaqsController extends Controller
{   
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-faq';
    }

    /**
     * Display a listing of the faqs.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {   
        if(request()->ajax())
        {   
            $model = Faqtitle::query();

            return datatables()->eloquent($model)
                        ->filter(function($q){

                            if(request()->has('title') && !empty(request('title')))
                            {   
                                $q->where("title","like","%".request('title')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $q->where("status",request('status'));
                            }

                            if(request()->has('created_at') && !empty(request('created_at')))
                            {       
                                $created_at = get_date_db_format(request('created_at'));

                                $q->where("created_at","like","%$created_at%");
                            }

                        }, true)
                        ->setTransformer(new FaqTransformer(new Faqtitle))
                        ->toJson();
        }

        return view('faqs.index',$this->data);
    }

    /**
     * Show the form for creating a new faq.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {   
        return view('faqs.create',$this->data);
    }

    private function validate_form($req)
    {
        $post = $req->all();

        $errors = [];

        if(isset($post['question']))
        {   
            foreach($post['question'] as $key => $ques)
            {   
                $ans = $post['answer'][$key];

                if(!$ques)
                {   
                    $errors['question['.$key.']'] = "This fields is required";
                }
                else if(strlen($ques) > 255)
                {
                    $errors['question['.$key.']'] = "Question can not have more than 255 character.";
                }
                if(!$ans)
                {
                    $errors['answer['.$key.']'] = "This fields is required";
                }
            }
        }   
        
        if(!$post['status'])
        {
             $errors['status'] = "This fields is required";
        }

        if(!$post['title'])
        {
             $errors['title'] = "This fields is required";
        }

        if($errors)
        {   
            die(json_encode(['status'=>'failed','type'=>'validation','msg'=>$errors]));
        }
    }

    /**
     * Store a new faq in the storage.
     *
     * @param App\Http\Requests\FaqsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $req)
    {   
        $post = $req->all();

        $success = true;

        if($post)
        {   
            
            $this->validate_form($req);

            // create faq title
                $arr = ['title'=>$req->get('title'),'status'=>$req->get('status')];
                $obj = Faqtitle::create($arr);
                $faq_title_id = $obj->id;
            // end create faq title

            if($faq_title_id)
            {   
                if(isset($post['question']))
                {
                    foreach($post['question'] as $key => $ques)
                    {   
                        $ans = $post['answer'][$key];
                        $ques_arr = ['faq_title_id'=>$faq_title_id,'question'=>$ques,'answer'=>$ans];

                        $obj_faq = Faq::create($ques_arr);

                        if(!$obj_faq->id)
                        {
                            $success = false;
                        }
                    }
                }
            }
        }

        if($success)
        {   
            $req->session()->flash('success','Record created successfully.');
            return response()->json(['status'=>'success']);
        }

        return response()->json(['status'=>'failed','type'=>'error','msg'=>'Error something went wrong.']);
  


        /*dd('you are her..');   
        try {
            
            $data = $request->getData();
            
            Faq::create($data);

            request()->session()->flash('success','Record created successfully.');

            return redirect()->route('faqs.faq.index')
                ->with('success_message', 'Faq was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }*/
    }

    /**
     * Display the specified faq.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $faq = Faq::findOrFail($id);

        return view('faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified faq.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $faq               = Faqtitle::with('questions')->findOrFail($id);
        $this->data['faq'] = $faq;
        return view('faqs.edit', $this->data);
    }

    /**
     * Update the specified faq in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\FaqsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id,Request $req)
    {   
        $post = $req->all();

        $success = true;

        if($post)
        {       
            $this->validate_form($req);
            
            // update faq title
                $obj_title         = Faqtitle::find($id);
                $obj_title->title  = $post['title'];
                $obj_title->status = $post['status'];
                $obj_title->save();                
            // end update faq title

            if(isset($post['question']))
            {   
                // delete existing questions

                $deletedRows = Faq::where('faq_title_id',$id)->delete();

                foreach($post['question'] as $key => $ques)
                {   
                    $ans      = $post['answer'][$key];
                    $ques_arr = ['faq_title_id'=>$id,'question'=>$ques,'answer'=>$ans];
                    $obj_faq  = Faq::create($ques_arr);

                    if(!$obj_faq->id)
                    {
                        $success = false;
                    }
                }
            }
        }

        if($success)
        {
            $req->session()->flash('success','Record updated successfully.');
            return response()->json(['status'=>'success']);
        }

        return response()->json(['status'=>'failed','type'=>'error','msg'=>'Error something went wrong.']);
        /*try
        {
            
            $data = $request->getData();
            
            $faq = Faq::findOrFail($id);
            $faq->update($data);
            request()->session()->flash('success','Record updated successfully.');
            return redirect()->route('faqs.faq.index')
                ->with('success_message', 'Faq was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }*/        
    }

    /**
     * Remove the specified faq from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {   
        try
        {   
            // delete titles
            $obj_title = Faqtitle::findOrFail($id);
            $obj_title->delete();

            // delete question answer
            Faq::where('faq_title_id',$id)->delete();
            
            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('faqs.faq.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Error record not deleted.');
            return back()->withInput();
        }
    }



}
