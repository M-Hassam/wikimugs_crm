<?php

namespace App\Http\Controllers;

use App\Models\WriterOrder;
use App\Models\{
    User,
    Order,
    LogModel,
    OrderFile,
    OrderComment
};
use Illuminate\Http\Request;
use Gate;

class WriterOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\WriterOrder  $writerOrder
     * @return \Illuminate\Http\Response
     */
    public function show(WriterOrder $writerOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WriterOrder  $writerOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(WriterOrder $writerOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WriterOrder  $writerOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WriterOrder $writerOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WriterOrder  $writerOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(WriterOrder $writerOrder)
    {
        //
    }

    public function autocomplete(Request $request)
    {
        $search = $request->q;

        $data = User::select("id","name")
        ->where('role_id',5)
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function freelanceAutocomplete(Request $request)
    {
        $search = $request->q;

        $data = User::select("id","name")
        ->where('role_id',8)
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function freelanceApplication(Request $request)
    {
        $search = $request->q;

        $data = User::select("id","name")
        ->where('role_id',8)
        ->where('name','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function assign_order(Request $request)
    {
        if(Gate::allows('permission',60)){
            $order = Order::with('writer')->find($request->order_id);
            $order->writer_id = $request->writer_id;
            $order->writer_deadline = $request->writer_deadline;
            $order->status_id = 3;
            $order->is_new = 0;
            $order->save();
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-status-updated',
                'description'=>auth()->user()->name.' has assigned order to '.$order->writer_id ?? "---".' with deadline '.$order->writer_deadline,
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            if(isset($request->attachments) && count($request->attachments)){
                foreach($request->attachments as $attachment){
                    $order_file = new OrderFile();
                    $order_file->order_id = $order->id;
                    $order_file->file = uploadFile($attachment, 'files');
                    $order_file->file_status_id = 2;
                    $order_file->save();
                }
            }

            if(isset($request->comment) && $request->has('comment')){
                $order_comment = new OrderComment;
                $order_comment->order_id = $order->id;
                $order_comment->comment = $request->comment;
                $order_comment->created_by = auth()->user()->id;
                $order_comment->save();
            }

            return response()->json(['status'=>true]);
        }else{
            abort(403);
        }
    }

    public function re_assign_order(Request $request)
    {
        if(Gate::allows('permission',63)){
            $order = Order::with('writer')->find($request->order_id);
            $order->writer_id = $request->writer_id;
            $order->writer_deadline = $request->writer_deadline;
            $order->is_reassigned = 1;
            $order->status_id = 3;
            $order->save();

            if(isset($request->attachments) && count($request->attachments)){
                foreach($request->attachments as $attachment){
                    $order_file = new OrderFile();
                    $order_file->order_id = $order->id;
                    $order_file->file = uploadFile($attachment, 'files');
                    $order_file->file_status_id = 4;
                    $order_file->save();
                }
            }

            if(isset($request->comment) && $request->has('comment')){
                $order_comment = new OrderComment;
                $order_comment->order_id = $order->id;
                $order_comment->comment = $request->comment;
                $order_comment->created_by = auth()->user()->id;
                $order_comment->save();
            }

            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-reassigned',
                'description'=>auth()->user()->name.' has re assigned order to '.$order['writer']->name ?? "---".' with deadline '.$order->writer_deadline,
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json(['status'=>true]);

        }else{
            abort(403);
        }
    }
}
