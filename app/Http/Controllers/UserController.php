<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
// use Spatie\Permission\Models\Role;
use App\Models\{
    Role,
    User,
    LeadStatus,
    UserTransaction
};
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',89)){
            $data['models'] = User::orderBy('id','desc')->get();
            $data['roles'] = LeadStatus::orderBy('id','desc')->get();
            return view('users.index',$data);
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
        if(Gate::allows('permission',90)){
            $data['roles'] = Role::orderBy('id','asc')->get();
            return view('users.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(Gate::allows('permission',90)){
            $data = $request->all();
            $data['serial_no'] = getSerialNo('App\Models\User'); //Calling helper function
            $data['created_by'] = auth()->user()->id;
            $file = '';
            if(isset($request->files) && count($request->files)){
                foreach($request->files as $f){
                    $file = $f;
                }
            }
            $data['identity_verification'] = (isset($request->files) && count($request->files)) ? uploadFile($file, 'files') : null;
            $data['password'] = isset($request->password) ? \Hash::make($request->password) : null;
            $user = new User;
            $user->fill($data);
            $user->save();
            User::saveRole($user,$data);
            return redirect()->route('users.index')->with('success','User added successfully');
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
        if(Gate::allows('permission',91)){
            $data['model'] = User::findOrFail($id);
            $data['roles'] = Role::orderBy('id','asc')->get();
            return view('users.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if(Gate::allows('permission',91)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            $user = User::find($id);
            $data['password'] = $request->has('password') ? \Hash::make($request->password) : $user->password;
            $user->update($data);
            $user::updateRole($user,$data);
            return redirect()->route('users.index')->with('success','User updated successfully');
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
        if(Gate::allows('permission',92)){
            User::find($id)->delete();
            return redirect()->route('users.index')->with('success','User deleted successfully');
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
    public function transaction($user_id)
    {
        if(Gate::allows('permission',93)){
            $data['models'] = UserTransaction::with('user')->where('user_id',$user_id)->get();
            $data['user_id'] = $user_id;
            return view('users.transactions.index',$data);
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
    public function createTransaction($user_id)
    {
        $data['user_id'] = $user_id;
        return view('users.transactions.add_edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTransaction(Request $request)
    {
        $data = $request->all();
        $data['attachments'] = isset($request->attachments) ? uploadFile($request->attachments, 'files') : null;
        $user_transaction = new UserTransaction;
        $user_transaction->fill($data);
        $user_transaction->save();
        return redirect()->route('users.transactions',['user'=>$request->user_id])->with('success','User added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editTransaction($transaction_id)
    {
        $data['model'] = UserTransaction::findOrFail($transaction_id);
        return view('users.transactions.add_edit',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTransaction(Request $request,$id)
    {
        $data = $request->all();
        $user_transaction = UserTransaction::findOrFail($id);
        $data['user_id'] = $user_transaction->user_id;
        $data['attachments'] = isset($request->attachments) ? uploadFile($request->attachments, 'files') : $user_transaction->attachments;
        $user_transaction->fill($data);
        $user_transaction->save();
        return redirect()->route('users.transactions',['user'=>$user_transaction->user_id])->with('success','User updated successfully');
    }

    public function fileImport(Request $request)
    {
        // dd($request->file('file'));
        $data = Excel::toArray(new UsersImport, $request->file('file')->store('temp'));
        dd($data);
    }

    public function fileImportimport()
    {
        return view('fileupload');
    }
}
