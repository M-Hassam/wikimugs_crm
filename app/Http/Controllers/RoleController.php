<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Role,
    Permission
};
use Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',84)){
            $data['models'] = Role::with('permissions')->orderBy('id','desc')->get();
            return view('rolepermissions.roles.index',$data);
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
        if(Gate::allows('permission',85)){
            $data['permissions'] = Permission::orderBy('id','asc')->get();
            return view('rolepermissions.roles.add_edit',$data);
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
    public function store(Request $request)
    {
        if(Gate::allows('permission',85)){
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $model = new Role;
            $model->fill($data);
            $model->save();
            $model::savePermission($model->id,$data);
            return redirect()->route('roles.index')->with('success','Role added successfully');
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
        if(Gate::allows('permission',86)){
            $data['model'] = Role::with('permissions')->findOrFail($id);
            $data['permissions'] = Permission::orderBy('id','asc')->get();
            return view('rolepermissions.roles.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::allows('permission',86)){
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $model = Role::findOrFail($id);
            $model->fill($data);
            $model->save();
            $model::updatePermission($model->id,$data);
            return redirect()->route('roles.index')->with('success','Role updated successfully');
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
        if(Gate::allows('permission',87)){
            $model = Role::findOrFail($id);
            if($model->delete()){
                return redirect()->route('roles.index')->with('success','Role deleted successfully');
            }
        }else{
            abort(403);
        }
    }
}
