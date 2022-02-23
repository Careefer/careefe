<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuesFormRequest;
use App\Models\Menues;
use Exception;
use App\Transformers\MenuesTransformer;


class MenuesController extends Controller
{

    /**
     * Display a listing of the menues.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        //$menuesObjects = Menues::paginate(25);


        if(request()->ajax())
        {   
            $model = menues::query();

            return datatables()->eloquent($model)
                        ->setTransformer(new MenuesTransformer(new menues))
                        ->toJson();
        }

        return view('menues.index');
    }

    /**
     * Show the form for creating a new menues.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $all_menues = Menues::where('parent','0')->get();

        return view('menues.create', compact('all_menues'));
    }

    /**
     * Store a new menues in the storage.
     *
     * @param App\Http\Requests\MenuesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(MenuesFormRequest $request)
    {
        try
        {   
            $data = $request->getData();
            
            $data['permission_name'] = slug_url($data['name']);
            
            Menues::create($data);

            request()->session()->flash('success','Record created successfully.');

            return redirect()->route('menues.menues.index');
        }
        catch(Exception $exception)
        {   
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified menues.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $menues = Menues::findOrFail($id);

        return view('menues.show', compact('menues'));
    }

    /**
     * Show the form for editing the specified menues.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $menues     = Menues::findOrFail($id);
        $all_menues = Menues::where('parent','0')->get();

        return view('menues.edit', compact('menues','all_menues'));
    }

    /**
     * Update the specified menues in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\MenuesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, MenuesFormRequest $request)
    {
        try
        {
            $data = $request->getData();

            $menues = Menues::findOrFail($id);
            $menues->update($data);
            request()->session()->flash('success','Record updated successfully.');
            return redirect()->route('menues.menues.index')
                ->with('success_message', 'Menues was successfully updated.');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified menues from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $menues = Menues::findOrFail($id);
            $menues->delete();

            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('menues.menues.index')
                ->with('success_message', 'Menues was successfully deleted.');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }



}
