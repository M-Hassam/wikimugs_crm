<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use App\Models\{
    Domain,
    Coupon,
    CouponType,
};
use Gate;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',75)){
            $data['models'] = Coupon::with('domain','type','user')->orderBy('id','desc')->get();
            return view('coupons.index',$data);
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
        if(Gate::allows('permission',76)){
            $data['coupon_types'] = CouponType::orderBy('id','desc')->get();
            return view('coupons.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CouponRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponRequest $request)
    {
        if(Gate::allows('permission',76)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Coupon::create($data);
            return redirect()->route('coupons.index')->with('success','Coupon added successfully');
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
        if(Gate::allows('permission',77)){
            $data['coupon_types'] = CouponType::orderBy('id','desc')->get();
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['model'] = Coupon::find($id);
            return view('coupons.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CouponRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponRequest $request, $id)
    {
        if(Gate::allows('permission',77)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Coupon::find($id)->update($data);
            return redirect()->route('coupons.index')->with('success','Coupon updated successfully');
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
        if(Gate::allows('permission',78)){
            Coupon::findOrFail($id)->delete();
            return redirect()->route('coupons.index')->with('success','Coupon deleted successfully');
        }else{
            abort(403);
        }
    }
}
