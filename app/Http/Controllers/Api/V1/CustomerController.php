<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\{
    CustomerSaveRequest,
    CustomerUpdateRequest
};
use App\Models\{
    Lead,
    Customer
};
use Mail;
use App\Mail\{
    CustomerSignUp
};

class CustomerController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomerSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function lead(Request $request)
    {
        $lead = Lead::where('email',$request->email)->first();
        if(isset($lead) && isset($lead->id)){
            return response()->json([
                'status' => 1,
                'message' =>'Lead created successfuly',
                'data' => $lead->id
            ]);
        }else{
            // dd('inside lead');
            // $lead->serial_no = getSerialNo('\App\Models\Customer');
            // $lead->timezone_id = $request->timezone_id ?? "";
            // $lead->last_name = $request->last_name ?? "";
            // $lead->is_email_notification = $request->is_email_notification ?? 0;
            // $lead->is_feedback_notification = $request->is_feedback_notification ?? 0;
            // $lead->is_promotion = $request->is_promotion ?? 0;
            // $lead->password = isset($request->password) ? \Hash::make($request->password) : \Hash::make($request->first_name.'9510');
            // $lead->status = 1;
            $lead = new Lead;
            $lead->domain_id = $request->domain_id ?? "";
            $lead->status_id = 1;
            $lead->name = $request->name ?? "";
            $lead->email = $request->email ?? "";
            $lead->phone = $request->phone ?? "";

            if($lead->save()){
                return response()->json([
                    'status' => 1,
                    'message' =>'Customer else created successfuly',
                    'data' => $lead->id
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' =>'Error while creating customer',
                    'data' => ''
                ]);
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomerSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerSaveRequest $request)
    {
        $customer = Customer::where('email',$request->email)->first();
        if(isset($customer) && isset($customer->id)){
            return response()->json([
                'status' => 1,
                'message' =>'Customer found successfuly',
                'data' => $customer,
                'is_already' => 1
            ]);
        }else{
            $cs = new Customer;
            $cs->serial_no = getSerialNo('\App\Models\Customer');
            $cs->domain_id = $request->domain_id ?? "";
            // $cs->timezone_id = $request->timezone_id ?? "";
            $cs->first_name = $request->first_name ?? "";
            $cs->last_name = $request->last_name ?? "";
            $cs->email = $request->email ?? "";
            $cs->phone = $request->phone ?? "";
            $cs->is_email_notification = $request->is_email_notification ?? 0;
            $cs->is_feedback_notification = $request->is_feedback_notification ?? 0;
            $cs->is_promotion = $request->is_promotion ?? 0;
            $cs->password = isset($request->password) ? \Hash::make($request->password) : \Hash::make($request->first_name.'9510');
            $cs->status = 1;

            if($cs->save()){
                $data['customer'] = $cs;
                Mail::to($cs->email)
                ->send(new CustomerSignUp($data));

                return response()->json([
                    'status' => 1,
                    'message' =>'Customer created successfuly',
                    'data' => $cs,
                    'is_already' => 0
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' =>'Error while creating customer',
                    'data' => '',
                    'is_already' => 0
                ]);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $customer = Customer::where(['domain_id'=>$request->domain_id,'email'=>$request->email])->first(['id','serial_no','domain_id','first_name','last_name','email','phone','is_email_notification','is_feedback_notification','is_promotion','password','status']);

        if(isset($customer->id)){
            return response()->json([
                'status' => 1,
                'message' =>'Customer found successfuly',
                'data' => $customer
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'Customer not found',
                'data' => ''
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomerSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request)
    {
        $cs = Customer::find($request->customer_id);
        if(isset($cs->id)){
            $cs->first_name = $request->first_name ?? "";
            $cs->last_name = $request->last_name ?? "";
            $cs->email = $request->email ?? "";
            $cs->phone = $request->phone ?? "";
            // $cs->is_email_notification = $request->is_email_notification ?? 0;
            // $cs->is_feedback_notification = $request->is_feedback_notification ?? 0;
            // $cs->is_promotion = $request->is_promotion ?? 0;
            $cs->password = isset($request->password) ? bcrypt($request->password) : $cs->password;
            if($cs->save()){
                return response()->json([
                    'status' => 1,
                    'message' =>'Customer updated successfuly',
                    'data' => $cs
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' =>'Error while updating customer',
                    'data' => ''
                ]);
            }
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'Customer not found',
                'data' => ''
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\CustomerSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $cs = Customer::find($request->customer_id);
        if(isset($cs->id)){
            $cs->password = isset($request->password) ? bcrypt($request->password) : $cs->password;
            $cs->is_password = 1;
            if($cs->save()){
                return response()->json([
                    'status' => 1,
                    'message' =>'Customer password updated successfuly',
                    'data' => $cs->id
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' =>'Error while updating customer password',
                    'data' => ''
                ]);
            }
        }else{
            return response()->json([
                'status' => 0,
                'message' =>'Customer not found',
                'data' => ''
            ]);
        }
    }
}
