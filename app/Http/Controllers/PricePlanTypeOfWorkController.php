<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PricePlanTypeOfWorkRequest;
use App\Models\{
    Domain,
    PricePlanTypeOfWork
};
use Gate;

class PricePlanTypeOfWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',21)){
            $data['models'] = PricePlanTypeOfWork::with('domain')->orderBy('id','desc')->get();
            return view('priceplans.typeofworks.index',$data);
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
        if(Gate::allows('permission',22)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            return view('priceplans.typeofworks.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PricePlanTypeOfWorkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PricePlanTypeOfWorkRequest $request)
    {
        if(Gate::allows('permission',22)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            PricePlanTypeOfWork::create($data);
            return redirect()->route('priceplan.type-of-works.index')->with('success','Type of work added successfully');
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
        if(Gate::allows('permission',23)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['model'] = PricePlanTypeOfWork::find($id);
            return view('priceplans.typeofworks.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PricePlanTypeOfWorkRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PricePlanTypeOfWorkRequest $request, $id)
    {
        if(Gate::allows('permission',23)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            PricePlanTypeOfWork::find($id)->update($data);
            return redirect()->route('priceplan.type-of-works.index')->with('success','Type of work updated successfully');
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
        if(Gate::allows('permission',24)){
            PricePlanTypeOfWork::find($id)->delete();
            return redirect()->route('priceplan.type-of-works.index')->with('success','Type of work deleted successfully');
        }else{
            abort(403);
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = PricePlanTypeOfWork::select("id","name")
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function autocomplete_order(Request $request)
    {
        $search = $request->q;
        $data = PricePlanTypeOfWork::order_options($search,$request->domain_id);
        // dd($data);
        return response()->json($data);
    }
}
