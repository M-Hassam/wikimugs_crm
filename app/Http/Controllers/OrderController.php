<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderCustomerRequest;
use App\Models\Order;
use App\Models\OrderFile;
use App\Models\Lead;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\OrderAddon;
use App\Models\PricePlan;
use App\Models\Status;
use App\Models\PricePlanNoOfPage;
use App\Models\PricePlanSetting;
use App\Models\OrderComment;
use App\Traits\MediaUploadingTrait;
use Database\Seeders\PricePlanSeeder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;
use App\Events\LogEvent;
use Event;
use App\Models\LogModel;
use App\Mail\Order\{
    Followup,
    SendCustomerOrder
};
use Mail;
use Gate;


class OrderController extends Controller
{
    use MediaUploadingTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Gate::allows('permission',72)){
            $orders = Order::query();
            if(isset($request->domain_id)){
                $orders->where('domain_id',$request->domain_id);
            }
            if(isset($request->status)){
                $orders->where('status_id',$request->status);
            }
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.index',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_awaiting()
    {
        if(Gate::allows('permission',50)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',1);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
        // Order::where('is_new',0)->where('status_id',1)->update(['is_new'=>1]);
            return view('orders.payment_awaiting',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        if(Gate::allows('permission',61)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',2);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.pending',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assigned()
    {
        if(Gate::allows('permission',66)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',3);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.assigned',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function writer_delivery()
    {
        if(Gate::allows('permission',67)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',4);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.writer_delivery',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delivered()
    {
        if(Gate::allows('permission',68)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',5);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.delivered',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modified()
    {
        if(Gate::allows('permission',69)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',6);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.modified',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        if(Gate::allows('permission',70)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',7);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.completed',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function canceled()
    {
        if(Gate::allows('permission',71)){
            $orders = Order::query();
            if(isset(request()->domain_id)){
                $orders->where('domain_id',request()->domain_id);
            }
            $orders->where('status_id',8);
            $data['orders_count'] = $orders->count();
            $data['models'] = $orders->with(['status','urgency','writer'])->orderBy('id','desc')->paginate(15);
            $data['order_statuses'] = Status::get(['id','title']);
            return view('orders.canceled',$data);
        }else{
            abort(403);
        }
    }

    public function get(Request $request)
    {
        $orders = Order::query();

        if(isset($request->domain_id))
            $orders->where('domain_id',$request->domain_id);

        if(isset($request->status_id))
            $orders->where('status_id',$request->status_id);

        if($request->status_id !='deleted')
            $orders = $orders->with([
                'domain',
                'status'
            ])->get();
        else
            $orders = $orders->with([
                'domain',
                'status'
            ])->onlyTrashed()->get();

        $order_statuses = Status::all()->ToArray();
        $orders->order_statuses = $order_statuses;
        if(count($orders) > 0)
        {
            return DataTables::of($orders)
            ->addIndexColumn()
            ->make(true);
        }

    }

    public function convert_to_order(\App\Models\Domain $domain,\App\Models\Lead $lead)
    {
        $addOns = PricePlanSetting::all();
        $data = [
            'addOns' => $addOns,
            'lead_id' => $lead->id,
            'domain_id'=>$domain->id
        ];
        return view('orders/create',$data);
    }

    public function view_order(Request $request)
    {
        // if(Gate::allows('permission',55)){
            $order = Order::with([
                'domain',
                'lead',
                'status',
                'customer',
                'subjects',
                'style',
                'level',
                'type_of_work',
                'comments',
                'comments.user',
                'urgency',
                'no_of_pages',
                'addons',
                'addons.addon',
                'files',
                'client_guidlines',
                'writing_deptartments',
                'writer_deliveries',
                'revision_writing_depts',
                'revision_deliveries',
                'revision_clients',
                'final_deliveries',
                'revision_for_writer',
                'order_guidelines'
            ])->find($request->id);
            $line_spacing = $order->line_spacing==2 ? 'Single Line Space' : 'Double Line Space';
            $data = [
                'order' => $order,
                'line_spacing' => $line_spacing,
                'order_comments' =>$order['comments']
            ];
            $order->update(['is_new'=>1]);

            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-status-updated',
                'description'=>auth()->user()->name.' has previewed order',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json($data);
        // }else{
        //     abort(403);
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('permission',51)){
            $addOns = PricePlanSetting::all();
            return view('orders/create')->with('addOns', $addOns);
        }else{
            abort(403);
        }
    }

    private function store_data($request)
    {
        DB::transaction(function() use ($request){

            if(isset($request->lead_id))
            {
               $lead = Lead::find($request->lead_id);
               $customer = Customer::where('phone',$lead['phone'])->first();
           }

           if(!isset($customer))
           {
            $customer = Customer::create([
                'domain_id' => $request->domain_id,
                'timezone_id' => 1,
                'first_name'=>isset($lead['name']) ? $lead['name'] : $request->name,
                'last_name'=>'',
                'serial_no'=>sprintf("%08d", mt_rand(1, 99999999)),
                'email'=>isset($lead['email']) ? $lead['email'] : $request->email,
                'phone'=>isset($lead['phone']) ? $lead['phone'] : $request->phone,
                'password'=>'password'
            ]);
        }

        $data = $request->all();
        $data['customer_id'] = $customer['id'];
        $data['created_by'] = auth()->id();
        $order = new Order();
        $order->fill($data);
        $order->save();

        if($order->save())
        {
            if(isset($request->attachments) && count($request->attachments))
            {
               foreach($request->attachments as $attachment)
               {
                $order_file = new OrderFile();
                $order_file->order_id = $order->id;
                $order_file->file = $attachment;
                $order_file->save();
            }
        }

        if(isset($lead))
        {
            $lead->lead_status_id = 2;
            $lead->save();
        }

        $log_data = [
            'log_type_id'=>2,
            'user_id'=>auth()->user()->id ?? null,
            'domain_id'=>$request->domain_id ?? null,
            'general_id'=>$order->id ?? null,
            'slug'=>'order-added',
            'description'=>auth()->user()->name.' has added new order',
            'created_at'=>date('y-m-d h:i:s')
        ];

        LogModel::insert($log_data);

        if($request->coupon_id !="")
        {
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$request->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-coupon-applied',
                'description'=>auth()->user()->name.' has aplied coupon to order',
                'created_at'=>date('y-m-d h:i:s')
            ];

            LogModel::insert($log_data);
        }
    }
});

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        if($this->store_data($request))
            return response()->json([
                'status'=>true
            ]);
    }

    public function store_with_customer(OrderCustomerRequest $request)
    {
        if($this->store_data($request))
            return response()->json([
                'status'=>true
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        if(Gate::allows('permission',53)){
            $addOns = PricePlanSetting::all();
            $data = [
                'addOns'=>$addOns,
                'order'=>$order
            ];
            return view('orders/create',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $data = $request->all();
        $order->fill($data);
        $order->save();

        if($order->save()){
            if(isset($request->attachments) && count($request->attachments)){
                foreach($request->attachments as $attachment){
                    $order_file = new OrderFile();
                    $order_file->order_id = $order->id;
                    $order_file->file = $attachment;
                    $order_file->save();
                }

                $log_data = [
                    'log_type_id'=>2,
                    'user_id'=>auth()->user()->id ?? null,
                    'domain_id'=>$request->domain_id ?? null,
                    'general_id'=>$order->id ?? null,
                    'slug'=>'order-updated',
                    'description'=>auth()->user()->name.' has updated order',
                    'created_at'=>date('y-m-d h:i:s')
                ];

                LogModel::insert($log_data);
            }

            return response()->json([
                'status'=>true
            ]);
        }

        return response()->json([
            'status'=>false
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if(Gate::allows('permission',57)){
            $order->delete();
            return redirect()->route('orders.index')->with('success','Order deleted successfully');
        }else{
            abort(403);
        }
    }

    public function status_change(Order $order,Request $request)
    {
        $order->update([
            'status_id'=>$request->status_id
        ]);

        $log_data = [
            'log_type_id'=>2,
            'user_id'=>auth()->user()->id ?? null,
            'domain_id'=>$request->domain_id ?? null,
            'general_id'=>$order->id ?? null,
            'slug'=>'order-status-updated',
            'description'=>auth()->user()->name.' has updated order status to '.$order->status->title,
            'created_at'=>date('y-m-d h:i:s')
        ];
        LogModel::insert($log_data);

        return response()->json(['status'=>true]);
    }

    public function statuses(Request $request)
    {
        $search = $request->q;

        $data = Status::select("id","title")
        ->where('title','LIKE',"%$search%")
        ->get();

        return response()->json($data);
    }

    public function storeMedia(Request $request)
    {
        $file = $request->file('file');
        $fileName = time().'.'.$file->extension();
        $file->move(public_path('files'),$fileName);
        return response()->json([
            'success'=>$fileName
        ]);
    }


    public function calculate(Request $request)
    {
        $total_amount=0;
        $discount_amount = 0;
        $grand_total_amount = 0;

        $pricePlan = PricePlan::with('type_of_work', 'level', 'urgency')
        ->where('domain_id', $request->domain_id)
        ->where('price_plan_urgency_id', $request->price_plan_urgency_id)
        ->where('price_plan_level_id',$request->price_plan_level_id)
        ->where('price_plan_type_of_work_id',$request->price_plan_type_of_work_id)
        ->first();

        // $noOfPages = PricePlanNoOfPage::where('domain_id', $request->domain_id)->first();
        if(isset($pricePlan) && !is_null($pricePlan)){
            $pricePlanAddOns = $request->addOns ? PricePlanSetting::whereIn('id', $request->addOns)->get() : collect();
            $basicDetails = $pricePlan->type_of_work->name . ' | ' . $pricePlan->level->name . ' | ' . $pricePlan->urgency->name . ' | ' .'No of Pages : '.$request->price_plan_no_of_page_id;

            $total_amount = round(($pricePlan->price *  $request->price_plan_no_of_page_id) + $pricePlanAddOns->sum('amount'));
            $grand_total_amount = $total_amount;

            if($request->discount_serial_no !=''){
                $coupon = Coupon::where('code',$request->discount_serial_no)->first();
                if($coupon){
                    if($coupon->coupon_type_id == 1){
                        $discount_amount = $coupon->discount;
                        $grand_total_amount = $total_amount - $coupon->discount;
                    }
                    else if($coupon->coupon_type_id == 2){
                        $discount_amount = $total_amount * $coupon->discount;
                        $grand_total_amount = $total_amount - ($total_amount * $coupon->discount);
                    }
                }
            }

            $grand_total_amount = $grand_total_amount - $request->manual_discount_amount;

            return [
                'single_spaced' => $request->spaced == 'single' ? true : false,
                'basic_details' => $basicDetails,
                'total_amount'   => $total_amount,
                'addOns'        => $pricePlanAddOns,
                'coupon_id'     => $coupon->id ?? '',
                'discount_amount'=>$discount_amount,
                'grand_total_amount'=>$grand_total_amount
            ];

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function log($id)
    {
        if(Gate::allows('permission',56)){
            $data['models'] = LogModel::where('log_type_id',2)->where('general_id',$id)->orderBy('id','desc')->get();
            $data['order_id'] = $id;
            return view('orders.log',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_status(Request $request)
    {
        if(Gate::allows('permission',52)){
            $order = Order::find($request->order_id);
            $order->status_id = (isset($request->payment_status) && $request->payment_status==1) ? 2 : 1;
            $order->is_new = 0;
            $order->save();
            $p_st = isset($request->payment_status) && $request->payment_status=='1' ? 'Paid' : 'Not Paid';
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-status-updated',
                'description'=>auth()->user()->name.' has update payment status to '.$p_st,
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json(['status'=>true]);
        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\LeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function followup_mail(Request $request)
    {
        if(Gate::allows('permission',54)){
            if($request->has('email_content')){
                $order = Order::with('customer')->find($request->order_id);
                if(isset($order['customer']->email)){
                    Mail::to($order['customer']->email)
                    // ->cc($moreUsers)
                    ->send(new Followup($request->email_content));

                    $log_data = [
                        'log_type_id'=>2,
                        'user_id'=>auth()->user()->id ?? null,
                        'domain_id'=>$order->domain_id ?? null,
                        'general_id'=>$order->id ?? null,
                        'slug'=>'order-followup-email',
                        'description'=>auth()->user()->name.' has sent follow up email',
                        'created_at'=>date('y-m-d h:i:s')
                    ];
                    LogModel::insert($log_data);
                }
            }
            return response()->json(['status'=>true]);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function discount(Request $request)
    {
        if(Gate::allows('permission',59)){
            $order = Order::find($request->order_id);
            $amount = 0;
            $old_price = $order->discount_amount+$order->addons_amount;
            $old_disc_amnt = $order->discount_amount;
            if(isset($request->discount_percentage)){
                $order->manual_discount_amount = $request->discount_percentage.'%';
                $percentage = ($order->discount_amount/100)*$request->discount_percentage;
                $amount = $order->discount_amount - $percentage;
                $order->discount_amount = $amount;
                $order->grand_total_amount = $amount+$order->addons_amount;
                $order->old_discount_amount = $old_disc_amnt;
            }
            if(isset($request->discount_amount)){
                $amount = $request->discount_amount;
                $disc_amnt = $order->discount_amount;
                $order->discount_amount = $amount;
                $order->grand_total_amount = $amount+$order->addons_amount;

                $diff = $amount - $disc_amnt;
                $percentage = (($diff / $disc_amnt)*100);
                $percentage = ($percentage < 0) ? $percentage * -1 : $percentage;
                $order->manual_discount_amount = round($percentage,2)."%" ?? 0;
                $order->old_discount_amount = $old_disc_amnt;
            }
            $order->save();
            $p_st = isset($request->discount_percentage) && $request->discount_percentage ? 'percentage' : 'amount';
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'discount-applied',
                'description'=>auth()->user()->name.' has applied discount in '.$p_st.' which is  '.$order->manual_discount_amount.' old price was $'.$old_price.' new price is $'.$order->grand_total_amount,
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json(['status'=>true]);
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
    public function comment(Request $request)
    {
        $order = Order::find($request->order_id);
        if(isset($request->comment)){
            $order_comment = new OrderComment;
            $order_comment->order_id = $order->id;
            $order_comment->comment = $request->comment;
            $order_comment->created_by = auth()->user()->id;
            $order_comment->save();
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-preview-commnets',
                'description'=>auth()->user()->name.' has added comments on preview model',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);
        }

        $fsid = $order->is_reassigned==1 ? 4 : 2;
        if(isset($request->attachments) && count($request->attachments)){
            foreach($request->attachments as $attachment){
                $order_file = new OrderFile();
                $order_file->order_id = $order->id;
                $order_file->file = uploadFile($attachment, 'files');//calling helper function
                $order_file->file_status_id = $fsid;
                $order_file->save();
            }
        }

        $log_data = [
            'log_type_id'=>2,
            'user_id'=>auth()->user()->id ?? null,
            'domain_id'=>$order->domain_id ?? null,
            'general_id'=>$order->id ?? null,
            'slug'=>'order-preview-files-added',
            'description'=>auth()->user()->name.' has added files on preview modal box',
            'created_at'=>date('y-m-d h:i:s')
        ];
        LogModel::insert($log_data);

        return redirect()->back()->with('success','Comments added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function file(Request $request)
    {
        $order = Order::find($request->order_id);
        $fsid = $order->is_reassigned==1 ? 4 : 2;
        if(isset($request->files)){
            foreach($request->files as $attachment){
                $order_file = new OrderFile();
                $order_file->order_id = $order->id;
                $order_file->file = uploadFile($attachment, 'files');//calling helper function
                $order_file->file_status_id = $fsid;
                $order_file->save();
            }
        }

        $log_data = [
            'log_type_id'=>2,
            'user_id'=>auth()->user()->id ?? null,
            'domain_id'=>$order->domain_id ?? null,
            'general_id'=>$order->id ?? null,
            'slug'=>'order-preview-files-added',
            'description'=>auth()->user()->name.' has added files on preview modal box',
            'created_at'=>date('y-m-d h:i:s')
        ];
        LogModel::insert($log_data);
        return redirect()->back()->with('success','File added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\LeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        if(Gate::allows('permission',64)){
            if(isset($request->attachments) && count($request->attachments)){
                $order = Order::with('customer')->findOrFail($request->order_id);
                foreach($request->attachments as $attachment){
                    $order_file = new OrderFile();
                    $order_file->order_id = $order->id;
                    $order_file->file = uploadFile($attachment, 'files');
                    $order_file->is_attach = 1;
                    $order_file->file_status_id = 7;
                    $order_file->save();
                    $data['order'] = $order;
                    $data['order_files'] = $order->files->where('is_attach',1);

                    // Mail::to($order['customer']->email)
                    // // ->cc($moreUsers)
                    // ->send(new SendCustomerOrder($data));

                    $log_data = [
                        'log_type_id'=>2,
                        'user_id'=>auth()->user()->id ?? null,
                        'domain_id'=>$order->domain_id ?? null,
                        'general_id'=>$order->id ?? null,
                        'slug'=>'order-delivered',
                        'description'=>auth()->user()->name.' has delivered order and sent email to customer',
                        'created_at'=>date('y-m-d h:i:s')
                    ];
                    LogModel::insert($log_data);
                }
                $order->status_id = 5;
                $order->save();
            }
            return redirect()->back()->with('success','Order delivered successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\LeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function mark_complete($id)
    {
        if(Gate::allows('permission',65)){
            $order = Order::findOrFail($id);
            $order->status_id = 7;
            $order->save();
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-completed',
                'description'=>auth()->user()->name.' has updated order status to completed',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);
            return redirect()->back()->with('success','Order updated successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function remove_writer(Order $order)
    {
        if(Gate::allows('permission',62)){
            $order->is_new = 0;
            $order->writer_id = null;
            $order->writer_deadline = null;
            $order->writer_submit_date = null;
            $order->status_id = 2;
            $order->save();

            $log_data = [
                'log_type_id'=>2,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$order->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-status-writer-removed',
                'description'=>auth()->user()->name.' has removed writer',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return redirect()->back()->with('success','Order Writer Removed successfully');
        }else{
            abort(403);
        }
    }
}
