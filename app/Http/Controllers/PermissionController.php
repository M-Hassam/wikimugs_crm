<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\Models\{
    Permission
};
use Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',83)){
            $data['models'] = Permission::orderBy('id','asc')->get();
            return view('rolepermissions.permissions.index',$data);
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
        if(Gate::allows('permission',80)){
            $data['heading_title'] = "Add Permission";
            return view('rolepermissions.permissions.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\Admin/PermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        if(Gate::allows('permission',80)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            $model = new Permission;
            $model->fill($data);
            $model->save();
            return redirect()->route('permissions.index')->with('success','Permission created successfully');
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
        if(Gate::allows('permission',81)){
            $data['model'] = Permission::findOrFail($id);
            $data['heading_title'] = "Edit Permission";
            return view('rolepermissions.permissions.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\Admin/PermissionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        if(Gate::allows('permission',81)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            $model = Permission::findOrFail($id);
            $model->fill($data);
            $model->save();
            return redirect()->route('permissions.index')->with('success','Permission updated successfully');
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
        if(Gate::allows('permission',82)){
            $model = Permission::find($id);
            if($model->delete()){
                return redirect()->route('permissions.index')->with('success','Permission deleted successfully');
            }
        }else{
            abort(403);
        }
    }
}
