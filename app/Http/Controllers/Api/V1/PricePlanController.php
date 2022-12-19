<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    PricePlan
};

class PricePlanController extends Controller
{
    public function index($id)
    {
        $data['price_plans'] = PricePlan::with('domain','level', 'urgency', 'type_of_work')->where('domain_id',$id)->get();
        if(isset($data['price_plans']) && count($data['price_plans'])){
            return response()->json([
                'status' => 1,
                'message' => 'Price plan found',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Price plan not found',
                'data' => ''
            ]);
        }
    }
}
