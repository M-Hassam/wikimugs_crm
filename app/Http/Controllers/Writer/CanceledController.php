<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Order,
    LogModel,
    OrderFile,
    OrderComment
};

class CanceledController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->check()){
            $data['models'] = Order::with('type_of_work','no_of_pages')
            ->where('writer_id',auth()->user()->id)
            ->where('status_id',8)
            ->get();
            return view('writers.canceled.index',$data);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $data['model'] = Order::find($id);
        return view('writers.canceled.add_edit',$data);
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
        $order = Order::find($id);
        $order->status_id = 4;
        $order->save();
        
        $o_data = [
            'log_type_id'=>2 ,
            'domain_id'=>$order->domain_id ?? null,
            'user_id'=>auth()->user()->id ?? null,
            'general_id'=>$order->id ?? null,
            'slug'=>'lead-status-updated',
            'description'=>auth()->user()->name.' writer has updated order status to delivered',
            'created_at'=>date('y-m-d h:i:s')
        ];
        LogModel::insert($o_data);

        if(isset($request->comment)){
            $order_comment = new OrderComment;
            $order_comment->order_id = $order->id;
            $order_comment->comment = $request->comment;
            $order_comment->created_by = auth()->user()->id;
            $order_comment->save();
        }
        if(isset($request->files) && count($request->files)){
            foreach($request->files as $a_file){
                foreach($a_file as $file){
                    $order_file = new OrderFile;
                    $order_file->order_id = $order->id;
                    $order_file->status_id = $order->status_id;
                    $order_file->file = uploadFile($file,'files');
                    // $order_file->created_by = auth()->user()->id;
                    $order_file->save();
                }
            }
        }
        return redirect()->route('writers.assigned.index')->with('success','Status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
