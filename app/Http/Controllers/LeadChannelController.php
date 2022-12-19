<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadChannelRequest;
use App\Models\{
    LeadChannel
};

class LeadChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['models'] = LeadChannel::orderBy('id','desc')->get();
        return view('leads.channels.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leads.channels.add_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LeadChannelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadChannelRequest $request)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        LeadChannel::create($data);
        return redirect()->route('leads.channels.index')->with('success','Lead channel added successfully');
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
        $data['model'] = LeadChannel::find($id);
        return view('leads.channels.add_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\LeadChannelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeadChannelRequest $request, $id)
    {
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        LeadChannel::find($id)->update($data);
        return redirect()->route('leads.channels.index')->with('success','Lead channel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LeadChannel::find($id)->delete();
        return redirect()->route('leads.channels.index')->with('success','Lead channel deleted successfully');
    }
}
