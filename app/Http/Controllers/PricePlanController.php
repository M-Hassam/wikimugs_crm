<?php

namespace App\Http\Controllers;

use App\Http\Requests\PricePlanRequest;
use App\Http\Requests\PricePlanImportRequest;
use App\Models\PricePlan;
use App\Models\PricePlanLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\PricePlanTypeOfWork;
use App\Models\PricePlanUrgency;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PricePlanExport;
use App\Imports\PricePlanImport;
use Gate;

class PricePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $pricePlans = PricePlan::query();
        
        if(isset($request->domain_id))
          $pricePlans->where('domain_id',$request->domain_id);

      $pricePlans = $pricePlans->with('domain','level', 'urgency', 'type_of_work')->get();

      return DataTables::of($pricePlans)
      ->addIndexColumn()
      ->make(true);
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',15)){
            return view('price-plan/index');
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
        if(Gate::allows('permission',16)){
            return view('price-plan/create');
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
    public function store(PricePlanRequest $request)
    {
        if(Gate::allows('permission',16)){
            $pricePlan = new PricePlan();
            $pricePlan->fill($request->all());
            $pricePlan->save();

            return response()->json([
                'success'=> true,
                'message' => 'Price plan updated successfully.'
            ]);
        }else{
            abort(403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::allows('permission',17)){
            $data['model'] = PricePlan::findOrFail($id);
            $data['price_plan_tofs'] = PricePlanTypeOfWork::get(['id','name']);
            $data['price_plan_levels'] = PricePlanLevel::get(['id','name']);
            $data['price_plan_urgencies'] = PricePlanUrgency::get(['id','name']);
            return view('price-plan.edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function update(PricePlanRequest $request, PricePlan $pricePlan)
    {
        if(Gate::allows('permission',17)){
            $pricePlan->price = $request->price;
            $pricePlan->domain_id = $request->domain_id;
            $pricePlan->price_plan_type_of_work_id = $request->price_plan_type_of_work_id;
            $pricePlan->price_plan_level_id = $request->price_plan_level_id;
            $pricePlan->price_plan_urgency_id = $request->price_plan_urgency_id;
            $pricePlan->save();
            return redirect()->route('price-plans.index')->with('success','Price plan updated successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PricePlan  $pricePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('permission',18)){
            PricePlan::findOrFail($id)->delete();
            return redirect()->route('price-plans.index')->with('success','Price plan deleted successfully');
        }else{
            abort(403);
        }
    }

    public function getCount()
    {
        return PricePlan::count();
    }

    public function export($id)
    {
        if(Gate::allows('permission',20)){
            return Excel::download(new PricePlanExport($id), 'price-plan.xlsx');
        }else{
            abort(403);
        }
    }

    public function import(PricePlanImportRequest $request)
    {
        if(Gate::allows('permission',19)){
            $data = Excel::toArray(new PricePLanImport, $request->file('file')->store('temp'));
            PricePlan::where('domain_id',$request->domain_id)->forceDelete();
            foreach($data[0] as $value){
                PricePlan::create([
                    'domain_id'=>$value[0] ?? null,
                    'price_plan_urgency_id'=>$value[2] ?? null,
                    'price_plan_level_id'=>$value[4] ?? null,
                    'price_plan_type_of_work_id'=>$value[6] ?? null,
                    'price'=>$value[8] ?? ""
                ]);
            }
            return redirect('price-plans')->with('success','Successfully Updated');
        }else{
            abort(403);
        }
    }
}
