<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CouponTypeRequest;
use App\Models\{
    CouponType
};

class CouponTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = CouponType::orderBy('id','desc')->get();
        return view('coupons.types.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons.types.add_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CouponTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponTypeRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        CouponType::create($data);
        return redirect()->route('CouponTypes.index')->with('success','Coupon Type added successfully');
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
        $data['model'] = CouponType::find($id);
        return view('coupons.types.add_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\CouponTypeRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponTypeRequest $request, $id)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        CouponType::find($id)->update($data);
        return redirect()->route('CouponTypes.index')->with('success','Coupon Type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CouponType::find($id)->delete();
        return redirect()->route('CouponTypes.index')->with('success','Coupon Type deleted successfully');
    }
}
