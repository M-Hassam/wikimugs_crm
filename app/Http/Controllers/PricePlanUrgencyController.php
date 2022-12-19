<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PricePlanUrgencyRequest;
use App\Models\{
    Domain,
    PricePlanUrgency
};
use Gate;

class PricePlanUrgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',29)){
            $data['models'] = PricePlanUrgency::with('domain')->orderBy('id','desc')->get();
            return view('priceplans.urgencies.index',$data);
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
        if(Gate::allows('permission',30)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            return view('priceplans.urgencies.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PricePlanUrgencyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PricePlanUrgencyRequest $request)
    {
        if(Gate::allows('permission',30)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            PricePlanUrgency::create($data);
            return redirect()->route('priceplan.urgencies.index')->with('success','Level added successfully');
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
        if(Gate::allows('permission',31)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['model'] = PricePlanUrgency::find($id);
            return view('priceplans.urgencies.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PricePlanUrgencyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PricePlanUrgencyRequest $request, $id)
    {
        if(Gate::allows('permission',31)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            PricePlanUrgency::find($id)->update($data);
            return redirect()->route('priceplan.urgencies.index')->with('success','Level updated successfully');
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
        if(Gate::allows('permission',32)){
            PricePlanUrgency::find($id)->delete();
            return redirect()->route('priceplan.urgencies.index')->with('success','Level deleted successfully');
        }else{
            abort(403);
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = PricePlanUrgency::select("id","name")
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function autocomplete_order(Request $request)
    {
        $search = $request->q;
        $data = PricePlanUrgency::order_options($search,$request->domain_id);
        // dd($data);
        return response()->json($data);
    }
}
