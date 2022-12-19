<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\{
    OrderRequest,
    OrderStoreRequest
};
use App\Models\{
    Lead,
    Order,
    Customer,
    LogModel,
    PricePlan,
    OrderFile,
    PricePlanAddOn,
    OrderAddon,
    OrderComment
};
use DB;
use Mail;
use App\Mail\Order\{
    OrderReceived
};
use App\Mail\{
    CustomerSignUp
};

use App\Jobs\CustomerSignupEmailJob;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderRequest $request)
    {
        $data = '';
        if($request->has('status_id') && isset($request->status_id)){
            $data = Order::with(['status','urgency','writer','final_order_files'])->where(['domain_id'=>$request->domain_id,'customer_id'=>$request->customer_id,'status_id'=>$request->status_id])->orderBy('id','desc')->get();
        }else{
            $data = Order::with(['status','urgency','writer','final_order_files'])->where(['domain_id'=>$request->domain_id,'customer_id'=>$request->customer_id])->orderBy('id','desc')->get();
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

    public function calculate(Request $request)
    {
        $total_amount=0;
        $discount_amount = 0;
        $grand_total_amount = 0;
        $words = 0;

        $pricePlan = PricePlan::with('type_of_work', 'level', 'urgency')
        ->where('domain_id', $request->domain_id)
        ->where('price_plan_urgency_id', $request->price_plan_urgency_id)
        ->where('price_plan_level_id',$request->price_plan_level_id)
        ->where('price_plan_type_of_work_id',$request->price_plan_type_of_work_id)
        ->first();
        if(isset($pricePlan) && !is_null($pricePlan)){

            if(isset($request->line_spacing) && $request->line_spacing==2){
                $words =  ($request->price_plan_no_of_page_id * 500)." words ";
            }else{
                $words = ($request->price_plan_no_of_page_id * 275)." words ";   
            }
            

            $pricePlanAddOns = $request->addOns ? PricePlanAddOn::whereIn('id', $request->addOns)->get() : collect();            
            $basicDetails = $pricePlan->type_of_work->name . ' | ' . $pricePlan->level->name . ' | ' . $pricePlan->urgency->name . ' | ' .'No of Pages : '.$request->price_plan_no_of_page_id."/".$words;
            $service_amount = ($pricePlan->price *  $request->price_plan_no_of_page_id);
            $total_amount = ($pricePlan->price *  $request->price_plan_no_of_page_id);
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
                        $grand_total_amount = $total_amount - ($totl_amount * $coupon->discount);
                    }
                }
            }

            if(isset($request->manual_discount_amount) && $request->manual_discount_amount == floatval($request->manual_discount_amount) && $request->manual_discount_amount > 0 ){
                $grand_total_amount = $grand_total_amount * $request->manual_discount_amount;
            }else{
                $grand_total_amount = $grand_total_amount - $request->manual_discount_amount;
            }

            if(isset($request->line_spacing) && $request->line_spacing==1){
                $grand_total_amount = $grand_total_amount;
            }elseif(isset($request->line_spacing) && $request->line_spacing==2){
                $grand_total_amount = $grand_total_amount * 2;
                $total_amount = $total_amount*2;
                $service_amount = $service_amount*2;
            }else{
                $grand_total_amount = $grand_total_amount;   
            }

            $total_amount = $total_amount + $pricePlanAddOns->sum('amount');
            $grand_total_amount = $grand_total_amount + $pricePlanAddOns->sum('amount');

            return [
                'single_spaced' => $request->spaced == 'single' ? true : false,
                'words' => $words,
                // 'basic_details' => $basicDetails,
                'coupon_id'     => $coupon->id ?? '',
                'addOns'        => $request->addOns,
                'total_amount'   => $total_amount ?? 0,
                'addons_amount' => $pricePlanAddOns->sum('amount'),
                'service_amount' => $service_amount ?? 0,
                'actual_service_amount' => isset($service_amount) ? $service_amount*2 :  0,
                'discounted_amount' => isset($service_amount) ? $service_amount : 0,
                // 'discounted_amount' => isset($service_amount) ? $service_amount/2 : 0,
                'discount_amount'=>$discount_amount ?? 0,
                'grand_total_amount'=>$grand_total_amount ?? 0
            ];

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $addOns = PricePlanSetting::all();
        return view('orders/create')->with('addOns', $addOns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\OrderStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderStoreRequest $request)
    {
        DB::beginTransaction();
        try{
            $customer_id = '';
            if(isset($request->customer_id)){
                $customer = Customer::find($request->customer_id);
                $customer_id = $customer->id;
            }
            if(isset($request->lead_id)){
                $lead = Lead::find($request->lead_id);
                if(isset($lead) && isset($lead->id)){
                    // $lead->lead_status_id = 2;
                    // $lead->save();
                    $check_customer = Customer::where(['email'=>$lead->email,'domain_id'=>$request->domain_id])->first();
                    if(isset($check_customer) && isset($check_customer->id)){
                        $customer_id = $check_customer->id;
                    }else{
                        $customer = new Customer;
                        $customer->serial_no = getSerialNo('\App\Models\Customer');;
                        $customer->domain_id = $lead->domain_id;
                        $customer->first_name = $lead->name;
                        $customer->email = $lead->email;
                        $customer->phone = $lead->phone;
                        $customer->password =isset($request->password) ? \Hash::make($request->password) : \Hash::make($lead->first_name.'9510');;
                        $customer->status = 1;
                        $customer->save();

                        $data['customer'] = $customer;
                        $email_data['customer'] = $customer;
                        $email_data['email'] = $customer->email;

                        // Mail::to($this->data['customer']->email)
                        // ->send(new CustomerSignUp($this->data));

                        // Mail::to($customer->email)
                        //     ->queue(new CustomerSignUp($email_data));

                        // CustomerSignupEmailJob::dispatchNow($email_data);
                        $customer_id = $customer->id;
                    }
                }
            }
            $order = new Order();
            $order->domain_id = $request->domain_id;
            $order->lead_id = $request->lead_id ?? null;
            $order->customer_id = $customer_id;
            $order->status_id = 1;
            $order->instructions = $request->instructions ?? null;
            $order->coupon_id = $request->coupon_id ?? null;
            $order->topic = $request->topic ?? null;
            $order->price_plan_type_of_work_id = $request->price_plan_type_of_work_id;
            $order->price_plan_level_id = $request->price_plan_level_id;
            $order->price_plan_urgency_id = $request->price_plan_urgency_id;
            $order->price_plan_no_of_page_id = $request->price_plan_no_of_page_id;
            $order->price_plan_indentation_id = $request->price_plan_indentation_id ?? null;
            $order->price_plan_subject_id = $request->price_plan_subject_id ?? null;
            $order->price_plan_style_id = $request->price_plan_style_id ?? null;
            $order->price_plan_language_id = $request->price_plan_language_id ?? null;
            $order->line_spacing = $request->line_spacing ?? null;
            $order->reference = $request->reference ?? null;
            $order->font_style = $request->font_style ?? null;
            $order->total_amount = $request->total_amount;
            $order->manual_discount_amount = $request->manual_discount_amount;
            $order->discount_amount = $request->discount_amount;
            $order->addons_amount = $request->addons_amount;
            $order->service_amount = $request->service_amount;
            $order->grand_total_amount = $request->grand_total_amount;
            $order->addons_amount = $request->addons_amount;
            $order->actual_total_amount = $request->grand_total_amount;
            $order->created_by = 4;
            if($order->save()){

                $data['customer'] = $order->customer;
                // Mail::to($order->customer->email)
                //         ->send(new CustomerSignUp($data));

                $order->order_no = $order->domain->code.'-'.rand(1111111,9999999);
                $order->save();
                isset($lead) ? $lead->delete() : '';
                if(isset($request->addOns) && count($request->addOns)){
                    foreach($request->addOns as $addon){
                        $order_addon = new OrderAddon();
                        $order_addon->order_id = $order->id;
                        $order_addon->price_plan_add_on_id = $addon;
                        $order_addon->save();
                    }
                }
                if(isset($request->attachments) && count($request->attachments)){
                    foreach($request->attachments as $attachment){
                        $order_file = new OrderFile();
                        $order_file->order_id = $order->id;
                        $order_file->file = uploadFile($attachment, 'files');//calling helper function
                        $order_file->file_status_id = 1;
                        $order_file->save();
                    }
                }
                $log_data = [
                    'log_type_id'=>2,
                    'user_id'=>null,
                    'domain_id'=>$request->domain_id ?? null,
                    'general_id'=>$order->id ?? null,
                    'slug'=>'order-added',
                    'description'=>'Added new order from website '.$request->domain_id,
                    'created_at'=>date('y-m-d h:i:s')
                ];
                LogModel::insert($log_data);

                if($request->coupon_id !=""){
                    $log_data1 = [
                        'log_type_id'=>2,
                        'user_id'=>null,
                        'domain_id'=>$request->domain_id ?? null,
                        'general_id'=>$order->id ?? null,
                        'slug'=>'order-coupon-applied',
                        'description'=>'Coupon applied to order coupon id is '.$request->coupon_id,
                        'created_at'=>date('y-m-d h:i:s')
                    ];
                    LogModel::insert($log_data1);
                }

                // $data['order'] = $order;
                // if(isset($order->customer->email)){
                //     Mail::to($order->customer->email)
                //     ->send(new OrderReceived($data));
                // }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();

            // dd($e->getMessage());

            return response()->json([
                'status' => 0,
                // 'message' =>"Unknown error occured",
                'message' =>$e->getMessage(),
                'data' => null
            ]);
        }
        return response()->json([
            'status' => 1,
            'message' =>'Order created successfuly',
            'data' => $order->id ?? null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\OrderStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(OrderStoreRequest $request)
    {
        DB::beginTransaction();
        try{
            $customer_id = '';
            if(isset($request->customer_id)){
                $customer = Customer::find($request->customer_id);
                $customer_id = $customer->id;
            }
            if(isset($request->lead_id)){
                $lead = Lead::find($request->lead_id);
                if(isset($lead) && isset($lead->id)){
                    $check_customer = Customer::where('email',$lead->email)->first();
                    if(isset($check_customer) && isset($check_customer->id)){
                        $customer_id = $check_customer->id;
                    }else{
                        $customer = new Customer;
                        $customer->serial_no = getSerialNo('\App\Models\Customer');;
                        $customer->domain_id = $lead->domain_id;
                        $customer->first_name = $lead->name;
                        $customer->email = $lead->email;
                        $customer->phone = $lead->phone;
                        $customer->password =isset($request->password) ? \Hash::make($request->password) : \Hash::make($lead->first_name.'9510');;
                        $customer->status = 1;
                        $customer->save();
                        $customer_id = $customer->id;
                    }
                }
            }
            $order = Order::find($request->order_id);
            $order->domain_id = $request->domain_id;
            $order->lead_id = $request->lead_id ?? null;
            $order->customer_id = $customer_id;
            $order->status_id = 1;
            $order->instructions = $request->instructions ?? null;
            $order->coupon_id = $request->coupon_id ?? null;
            $order->topic = $request->topic ?? null;
            $order->price_plan_type_of_work_id = $request->price_plan_type_of_work_id;
            $order->price_plan_level_id = $request->price_plan_level_id;
            $order->price_plan_urgency_id = $request->price_plan_urgency_id;
            $order->price_plan_no_of_page_id = $request->price_plan_no_of_page_id;
            $order->price_plan_indentation_id = $request->price_plan_indentation_id ?? null;
            $order->price_plan_subject_id = $request->price_plan_subject_id ?? null;
            $order->price_plan_style_id = $request->price_plan_style_id ?? null;
            $order->price_plan_language_id = $request->price_plan_language_id ?? null;
            $order->line_spacing = $request->line_spacing ?? null;
            $order->reference = $request->reference ?? null;
            $order->font_style = $request->font_style ?? null;
            $order->total_amount = $request->total_amount;
            $order->manual_discount_amount = $request->manual_discount_amount;
            $order->discount_amount = $request->discount_amount;
            $order->addons_amount = $request->addons_amount;
            $order->service_amount = $request->service_amount;
            $order->grand_total_amount = $request->grand_total_amount;
            $order->addons_amount = $request->addons_amount;
            $order->actual_total_amount = $request->grand_total_amount;
            $order->created_by = 4;
            if($order->save()){
                if(isset($request->addOns) && count($request->addOns)){
                    if(isset($order->addons) && count($order->addons)){
                        foreach($order->addons as $old_addon){
                            $old_addon->delete();
                        }
                    }
                    foreach($request->addOns as $addon){
                        $order_addon = new OrderAddon();
                        $order_addon->order_id = $order->id;
                        $order_addon->price_plan_add_on_id = $addon;
                        $order_addon->save();
                    }
                }
                if(isset($request->attachments) && count($request->attachments)){
                    foreach($request->attachments as $attachment){
                        $order_file = new OrderFile();
                        $order_file->order_id = $order->id;
                        $order_file->file = uploadFile($attachment, 'files');//calling helper function
                        $order_file->file_status_id = 1;
                        $order_file->save();
                    }
                }
                $log_data = [
                    'log_type_id'=>2,
                    'user_id'=>null,
                    'domain_id'=>$request->domain_id ?? null,
                    'general_id'=>$order->id ?? null,
                    'slug'=>'order-updated',
                    'description'=>'updated an order from website '.$request->domain_id,
                    'created_at'=>date('y-m-d h:i:s')
                ];
                LogModel::insert($log_data);

                if($request->coupon_id !=""){
                    $log_data1 = [
                        'log_type_id'=>2,
                        'user_id'=>null,
                        'domain_id'=>$request->domain_id ?? null,
                        'general_id'=>$order->id ?? null,
                        'slug'=>'order-coupon-updated',
                        'description'=>'Coupon updated to order coupon id is '.$request->coupon_id,
                        'created_at'=>date('y-m-d h:i:s')
                    ];
                    LogModel::insert($log_data1);
                }

                // $data['order'] = $order;
                // if(isset($order->customer->email)){
                //     Mail::to($order->customer->email)
                //     ->send(new OrderReceived($data));
                // }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'message' =>$e->getMessage(),
                'data' => null
            ]);
        }
        return response()->json([
            'status' => 1,
            'message' =>'Order updated successfuly',
            'data' => $order->id ?? null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $order = Order::with(['status','urgency','writer','level','type_of_work','urgency','no_of_pages','customer','subjects','style','addons','addons.addon','files'])->where(['domain_id'=>$request->domain_id,'id'=>$request->order_id])->first();
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
    public function showEdit(Request $request)
    {
        $order = Order::with(['status','urgency','writer','level','type_of_work','urgency','no_of_pages','customer','subjects','style','addons','addons.addon','files'])->where(['domain_id'=>$request->domain_id,'id'=>$request->order_id])->first();
        if(isset($order) && isset($order->id)){
            $order->discount_amount = isset($order->old_discount_amount) ? $order->old_discount_amount : $order->discount_amount;
            $order->grand_total_amount = $order->discount_amount + $order->addons_amount;
            $order->manual_discount_amount = 0;
            $order->save();

            $log_data = [
                'log_type_id'=>2,
                'user_id'=>4,
                'domain_id'=>$request->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-edit--order',
                'description'=>'clicked order edit icon from website order page '.$request->domain_id,
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markModified(Request $request)
    {
        $order = Order::with('files')->find($request->order_id);
        if(isset($order) && isset($order->id)){
            $order->status_id = $request->status_id ?? 6;
            $order->is_new = 0;
            $order->save();

            $oc = new OrderComment;
            $oc->order_id = $order->id;
            $oc->comment = $request->comment;
            $oc->created_by = 4;
            $oc->save();

            if(isset($order['files']) && count($order['files'])){
                foreach ($order['files'] as $key => $o_file) {
                    $o_file->is_attach = 0;
                    $o_file->save();
                }
            }

            if(isset($request->attachments) && count($request->attachments)){
                foreach($request->attachments as $attachment){
                    $order_file = new OrderFile();
                    $order_file->order_id = $order->id;
                    $order_file->file = uploadFile($attachment, 'files');//calling helper function
                    $order_file->file_status_id = 6;
                    $order_file->save();
                }
            }

            $log_data = [
                'log_type_id'=>2,
                'user_id'=>4,
                'domain_id'=>$request->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-completed-userarea',
                'description'=>'User marked completed from userarea',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json([
                'status' => 1,
                'message' =>'Order marked modified',
                'data' => ''
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
    public function markPaid(Request $request)
    {
        $order = Order::with('files')->find($request->order_id);
        if(isset($order) && isset($order->id)){
            $order->status_id = $request->status_id ?? 2;
            $order->is_new = 0;
            $order->save();

            $log_data = [
                'log_type_id'=>2,
                'user_id'=>4,
                'domain_id'=>$request->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-mark-paid-user',
                'description'=>'User paid order',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json([
                'status' => 1,
                'message' =>'Order marked paid',
                'data' => ''
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
    public function updateOrderStatus(Request $request)
    {
        $order = Order::find($request->order_id);
        if(isset($order) && isset($order->id)){
            $order->status_id = $request->status_id;
            $order->save();
            $log_data = [
                'log_type_id'=>2,
                'user_id'=>4,
                'domain_id'=>$request->domain_id ?? null,
                'general_id'=>$order->id ?? null,
                'slug'=>'order-completed-userarea',
                'description'=>'User marked completed from userarea',
                'created_at'=>date('y-m-d h:i:s')
            ];
            LogModel::insert($log_data);

            return response()->json([
                'status' => 1,
                'message' =>'Order marked completed',
                'data' => ''
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
