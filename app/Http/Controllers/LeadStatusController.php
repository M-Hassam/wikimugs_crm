<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadStatusRequest;
use App\Models\{
    LeadStatus
};

class LeadStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = LeadStatus::orderBy('id','desc')->get();
        return view('leads.statuses.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leads.statuses.add_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LeadStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadStatusRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        LeadStatus::create($data);
        return redirect()->route('leads.statuses.index')->with('success','Lead status added successfully');
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
        $data['model'] = LeadStatus::find($id);
        return view('leads.statuses.add_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\LeadStatusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeadStatusRequest $request, $id)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        LeadStatus::find($id)->update($data);
        return redirect()->route('leads.statuses.index')->with('success','Lead status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LeadStatus::find($id)->delete();
        return redirect()->route('leads.statuses.index')->with('success','Lead status deleted successfully');
    }
}
