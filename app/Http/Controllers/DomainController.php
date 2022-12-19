<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DomainRequest;
use App\Models\{
    Tier,
    Region,
    Domain,
};
use Gate;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',10)){
            $data['models'] = Domain::with('region','tier')->orderBy('id','desc')->get();
            return view('domains.index',$data);
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
        if(Gate::allows('permission',11)){
            $data['regions'] = Region::orderBy('id','desc')->get();
            $data['tiers'] = Tier::orderBy('id','desc')->get();
            return view('domains.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DomainRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DomainRequest $request)
    {
        if(Gate::allows('permission',11)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Domain::create($data);
            return redirect()->route('domains.index')->with('success','Domain added successfully');
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
        if(Gate::allows('permission',12)){
            $data['model'] = Domain::with('region','tier')->find($id);
            $data['regions'] = Region::orderBy('id','desc')->get();
            $data['tiers'] = Tier::orderBy('id','desc')->get();
            return view('domains.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DomainRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DomainRequest $request, $id)
    {
        if(Gate::allows('permission',12)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Domain::find($id)->update($data);
            return redirect()->route('domains.index')->with('success','Domain updated successfully');
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
        if(Gate::allows('permission',13)){
            Domain::find($id)->delete();
            return redirect()->route('domains.index')->with('success','Domain deleted successfully');
        }else{
            abort(403);
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = Domain::select("id","name")
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }
}
