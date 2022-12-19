<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\{
    LeadSaveRequest,
};
use App\Models\{
    Lead,
    Customer
};

class LeadController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LeadSaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadSaveRequest $request)
    {
        $customer = Customer::where(['email'=>$request->email, 'domain_id' =>$request->domain_id])->first();
        if(isset($customer) && isset($customer->id)){
            $customer_id = $customer->id;
            return response()->json([
                'status' => 1,
                'message' =>'Lead customer found successfuly',
                'customer' => 1,
                'data' => $customer_id
            ]);
        }
        $lead = Lead::where(['email'=>$request->email, 'domain_id' =>$request->domain_id])->first();
        if(isset($lead) && isset($lead->id)){
            return response()->json([
                'status' => 1,
                'message' =>'Lead found successfuly',
                'data' => $lead->id
            ]);
        }else{
            $lead = new Lead;
            $lead->domain_id = $request->domain_id ?? "";
            $lead->lead_status_id = 1;
            $lead->name = $request->name ?? "";
            $lead->email = $request->email ?? "";
            $lead->phone = $request->phone ?? "";
            if($lead->save()){
                return response()->json([
                    'status' => 1,
                    'message' =>'Lead created successfuly',
                    'data' => $lead->id
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' =>'Error while creating lead',
                    'data' => ''
                ]);
            }
        }
    }
}
