<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PricePlanLevelRequest;
use App\Models\{
    Domain,
    PricePlanLevel,
    PricePlan
};
use Gate;

class PricePlanLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',25)){
            $data['models'] = PricePlanLevel::with('domain')->orderBy('id','desc')->get();
            return view('priceplans.levels.index',$data);
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
        if(Gate::allows('permission',26)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            return view('priceplans.levels.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PricePlanLevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PricePlanLevelRequest $request)
    {
        if(Gate::allows('permission',26)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            PricePlanLevel::create($data);
            return redirect()->route('priceplan.levels.index')->with('success','Level added successfully');
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
        if(Gate::allows('permission',27)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['model'] = PricePlanLevel::find($id);
            return view('priceplans.levels.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PricePlanLevelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PricePlanLevelRequest $request, $id)
    {
        if(Gate::allows('permission',27)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            PricePlanLevel::find($id)->update($data);
            return redirect()->route('priceplan.levels.index')->with('success','Level updated successfully');
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
        if(Gate::allows('permission',28)){
            PricePlanLevel::find($id)->delete();
            return redirect()->route('priceplan.levels.index')->with('success','Level deleted successfully');
        }else{
            abort(403);
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = PricePlanLevel::select("id","name")
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function autocomplete_order(Request $request)
    {
        // dd($request->all());
        $search = $request->q;
        $data = PricePlanLevel::order_options($search,$request->domain_id);
        // dd($data);
        return response()->json($data);
    }
}
