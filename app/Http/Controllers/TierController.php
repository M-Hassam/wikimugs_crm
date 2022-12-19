<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TierRequest;
use App\Models\{
    Tier
};
use Gate;

class TierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',6)){
            $data['models'] = Tier::orderBy('id','desc')->get();
            return view('domains.tiers.index',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('permission',7)){
            return view('domains.tiers.add_edit');
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TierRequest $request)
    {
        if(Gate::allows('permission',7)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Tier::create($data);
            return redirect()->route('tiers.index')->with('success','Tier added successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::allows('permission',8)){
            $data['model'] = Tier::find($id);
            return view('domains.tiers.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TierRequest $request, $id)
    {
        if(Gate::allows('permission',8)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Tier::find($id)->update($data);
            return redirect()->route('tiers.index')->with('success','Tier updated successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('permission',9)){
            Tier::findOrFail($id)->delete();
            return redirect()->route('tiers.index')->with('success','Tier deleted successfully');
        }else{
            abort(403);
        }
    }
}
