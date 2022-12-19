<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Gate;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::allows('permission',73)){
            $orders = Order::query();
            if(isset($request->email)){
                $email = $request->email;
                $orders->whereHas('customer',function($query) use($email){
                    $query->where('email',$email);
                });
            }

            if(isset($request->name)){
                $name = $request->name;
                $orders->whereHas('customer',function($query) use($name){
                    $query->where('first_name',$name);
                });
            }

            if(isset($request->customer_id)){
                $orders->where('customer_id',$request->customer_id);
            }
            if(isset($request->order_id)){
                $orders->where('order_no',$request->order_id);
            }

            $data['models'] = $orders->with(['customer'])->orderBy('id','desc')->get();
            return view('search.form',$data);
        }else{
            abort(403);
        }
    }
}
