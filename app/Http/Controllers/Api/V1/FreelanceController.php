<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\Freelance\{
    UserRequest
};
use App\Models\{
    User,
    Order,
    LogModel,
    OrderFile,
    OrderComment,
    UserTransaction,
    OrderApplication
};

class FreelanceController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $request)
    {
        $user = User::where(['email'=>$request->email])->first(['id','role_id','serial_no','status','name','email','phone','password','address']);
        if(isset($user->id)){
            return response()->json([
                'status' => 1,
                'message' =>'User found successfuly',
                'data' => $user
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'User does not exists',
                'data' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function availableOrders()
    {
        $orders = Order::where(['status_id'=>2])->with([
            'domain','status','customer','level','type_of_work','urgency','no_of_pages','files','subjects'])
        ->whereHas('urgency', function($q){
                            // dd('')
        })
        ->orderby('id','desc')
        ->take(20)
        ->get();
        if(isset($orders)){
            return response()->json([
                'status' => 1,
                'message' =>'Order found successfuly',
                'data' => $orders
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'Order does not exists',
                'data' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showOrder(Request $request)
    {
        $order = Order::with(['status','urgency','writer','level','type_of_work','urgency','no_of_pages','customer','subjects','style','addons','addons.addon','files'])->where(['order_no'=>$request->order_no])->first();
        if(isset($order) && isset($order->id)){
            return response()->json([
                'status' => 1,
                'message' =>'Order Found',
                'data' => $order
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'No Order Found',
                'data' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apply(Request $request)
    {   
        $check = OrderApplication::where(['user_id' =>$request->user_id, 'order_id' => $request->order_id])->first();
        if(isset($check) && isset($check->id)){
            return response()->json([
                'status' => 1,
                'message' =>'Already applied',
                'data' => ''
            ]);
        }
        $order_application = new OrderApplication;
        $order_application->user_id = $request->user_id;
        $order_application->order_id = $request->order_id;

        if($order_application->save()){
            return response()->json([
                'status' => 1,
                'message' =>'Successfully applied',
                'data' => ''
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'Error while applying order',
                'data' => ''
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myOrders(Request $request)
    {
        $data = '';
        if($request->has('status_id') && isset($request->status_id)){
            $data = Order::with(['status','urgency','writer','final_order_files','type_of_work','subjects'])->where(['writer_id'=>$request->writer_id,'status_id'=>$request->status_id])->orderBy('id','desc')->get();
        }else{
            $data = Order::with(['status','urgency','writer','final_order_files','type_of_work','subjects'])->where(['writer_id'=>$request->writer_id])->orderBy('id','desc')->get();
        }
        if(isset($data) && count($data)){
            return response()->json([
                'status' => 1,
                'message' =>'Orders Found',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'No Order Found',
                'data' => ''
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inProcess(Request $request)
    {
        $data = Order::with('status','level','type_of_work','urgency','no_of_pages','files','subjects')
        ->where('writer_id',$request->writer_id)
        ->where(['status_id'=>3,'is_reassigned'=>0])
        ->get();
        if(isset($data) && count($data)){
            return response()->json([
                'status' => 1,
                'message' =>'Orders Found',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'No Order Found',
                'data' => ''
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->status_id = 4;
        $order->is_new = 0;
        $order->writer_submit_date = date('Y-m-d');
        $order->save();
        $file_status_id = $order->is_reassigned==1 ? 5 : 3;

        $o_data = [
            'log_type_id'=>2 ,
            'domain_id'=>$order->domain_id ?? null,
            'user_id'=>auth()->user()->id ?? null,
            'general_id'=>$order->id ?? null,
            'slug'=>'order-status-delivered',
            'description'=>' writer has updated order status to delivered and uploaded files',
            'created_at'=>date('y-m-d h:i:s')
        ];
        LogModel::insert($o_data);

        if(isset($request->comment)){
            $order_comment = new OrderComment;
            $order_comment->order_id = $order->id;
            $order_comment->comment = $request->comment;
            $order_comment->created_by = $request->created_by;
            $order_comment->save();
        }

        if(isset($request->attachments) && count($request->attachments)){
            foreach($request->attachments as $a_file){
                $order_file = new OrderFile;
                $order_file->order_id = $order->id;
                $order_file->status_id = $order->status_id;
                $order_file->file = uploadFile($a_file, 'files');
                $order_file->created_by = $request->created_by;
                $order_file->file_status_id = $file_status_id;
                $order_file->save();
            }
        }
        return response()->json([
            'status' => 1,
            'message' =>'Order submitted successfuly',
            'data' => ""
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reAssigned(Request $request)
    {
        $data = Order::with('status','level','type_of_work','urgency','no_of_pages','files','subjects')
        ->where('writer_id',$request->writer_id)
        ->where(['status_id'=>3,'is_reassigned'=>1])
        ->get();
        return response()->json([
            'status' => 1,
            'message' =>'Orders Found',
            'data' => $data ?? 0
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function previous(Request $request)
    {
        $data = Order::with('status','level','type_of_work','urgency','no_of_pages','files','subjects')
        ->where('writer_id',$request->writer_id)
        ->whereIn('status_id',['4','5','6','7','8'])
        // ->where(['status_id'=>3,'is_reassigned'=>0])
        ->get();
        if(isset($data) && count($data)){
            return response()->json([
                'status' => 1,
                'message' =>'Orders Found',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'No Order Found',
                'data' => ''
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction(Request $request)
    {
        $data = UserTransaction::with(['user'])
        ->where('user_id',$request->user_id)
        ->get();
        return response()->json([
            'status' => 1,
            'message' =>'Transactions Found',
            'data' => $data ?? 0
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {   
        $u_c = User::where('email',$request->email)->first();
        if(isset($u_c) && isset($u_c->id)){
            return response()->json([
                'status' => 0,
                'message' =>'User already exist',
                'data' => ''
            ]);
        }else{
            $model = new User;
            $model->serial_no = getSerialNo('\App\Models\User');
            $model->status = $request->status ?? 1;
            $model->name = $request->name ?? null;
            $model->email = $request->email ?? null;
            $model->phone = $request->phone ?? null;
            $model->password = isset($request->password) ? \Hash::make($request->password) : null;
            $model->created_by = $request->created_by ?? null;
            $model->address = $request->address ?? null;
            $model->identity_verification = $request->identity_verification ?? null;
            $model->save();

            if(isset($model)){
                return response()->json([
                    'status' => 1,
                    'message' =>'User created successfuly',
                    'data' => $model
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' =>'Error while creating user',
                    'data' => ''
                ]);
            }
        }
    }
}
