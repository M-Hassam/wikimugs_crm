<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionRequest;
use App\Models\{
    Region
};
use Gate;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',2)){
            $data['models'] = Region::orderBy('id','desc')->get();
            return view('domains.regions.index',$data);
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
        if(Gate::allows('permission',3)){
            return view('domains.regions.add_edit');
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionRequest $request)
    {
        if(Gate::allows('permission',3)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Region::create($data);
            return redirect()->route('regions.index')->with('success','Region added successfully');
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
        if(Gate::allows('permission',4)){
            $data['model'] = Region::find($id);
            return view('domains.regions.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RegionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegionRequest $request, $id)
    {
        if(Gate::allows('permission',4)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Region::find($id)->update($data);
            return redirect()->route('regions.index')->with('success','Region updated successfully');
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
        if(Gate::allows('permission',5)){
            Region::find($id)->delete();
            return redirect()->route('regions.index')->with('success','Region deleted successfully');
        }else{
            abort(403);
        }
    }
}
