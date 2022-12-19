<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;
use App\Models\{
    Order,
    Domain,
    Customer,
    LeadStatus
};
use Gate;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',34)){
            $data['models'] = Customer::with('domain','timezone')->orderBy('id','desc')->get();
            return view('customers.index',$data);
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
        if(Gate::allows('permission',35)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            return view('customers.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        if(Gate::allows('permission',35)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Customer::create($data);
            return redirect()->route('customers.index')->with('success','Customer added successfully');
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
        if(Gate::allows('permission',30)){
            $data['models'] = Order::where('customer_id',$id)->get();
            return view('customers.orders',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::allows('permission',30)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['model'] = Customer::find($id);
            return view('customers.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CustomerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        if(Gate::allows('permission',30)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Customer::find($id)->update($data);
            return redirect()->route('customers.index')->with('success','Customer updated successfully');
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
        if(Gate::allows('permission',30)){
            Customer::find($id)->delete();
            return redirect()->route('customers.index')->with('success','Customer deleted successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        if(Gate::allows('permission',30)){
            if(isset($request->customer_id)){
                $customer = Customer::find($request->customer_id);
                $customer->password = \Hash::make($request->password);
                $customer->save();
            }
            return redirect()->route('customers.index')->with('success','Customer password updated successfully');
        }else{
            abort(403);
        }
    }
}
