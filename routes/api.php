<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    PricePlanController,
    CustomerController,
    LeadController,
    OrderController,
    FreelanceController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('price-plan', function (Request $request) {
    $domain_id = $request->domain_id;
    if (is_null($domain_id))
        return response()->json([
            'message' => "Arg?:domin_id is required",
            'success' => false,
        ]);

    $data = [];
    $price_plan = \App\Models\PricePlan::where('domain_id', $domain_id)->get([
        "price_plan_urgency_id",
        "price_plan_level_id",
        "price_plan_type_of_work_id"
    ])->toArray();

    $price_plan_urgency_id = array_unique(array_column($price_plan, 'price_plan_urgency_id'));
    $price_plan_level_id = array_unique(array_column($price_plan, 'price_plan_level_id'));
    $price_plan_type_of_work_id = array_unique(array_column($price_plan, 'price_plan_type_of_work_id'));

    $data['urgencies'] = \App\Models\PricePlanUrgency::whereIn('id', $price_plan_urgency_id)->pluck('name', 'id');
    $data['levels'] = \App\Models\PricePlanLevel::whereIn('id', $price_plan_level_id)->pluck('name', 'id');
    $data['type_of_works'] = \App\Models\PricePlanTypeOfWork::whereIn('id', $price_plan_type_of_work_id)->pluck('name', 'id');
    $data['subjects'] = \App\Models\PricePlanSubject::pluck('name', 'id');
    $data['addons'] = \App\Models\PricePlanAddOn::where('domain_id', $domain_id)->get(['id','name','amount']);

    return response()->json([
        'data' => $data,
        'success' => true,
    ]);
});
Route::post('orders/calculate', [OrderController::class, 'calculate'])->name('api.orders.calculate');
// Route::post('orders/calculate', [OrderController::class, 'calculate'])->name('api.orders.calculate');
// Route::post('orders/calculate', [\App\Http\Controllers\OrderController::class, 'calculate'])->name('api.orders.calculate');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'v1','as'=>'v1.','namespace'=>'Api\V1'],function(){

    Route::get('price-plan', function (Request $request) {
        $domain_id = $request->domain_id;
        if (is_null($domain_id))
            return response()->json([
                'message' => "Arg?:domin_id is required",
                'success' => false,
            ]);
        // $price_plan = \App\Models\PricePlan::with(['domain','level','urgency'])->where('domain_id', $domain_id)->get([
        //     'id',
        //     'domain_id',
        //     'price_plan_urgency_id',
        //     'price_plan_level_id',
        //     // 'price_plan_type_of_work_id',
        //     'price'
        // ]);

        // $price_plan = \App\Models\PricePlan::with(['domain','level','urgency'])->where('domain_id', $domain_id)->get([
        //     'id',
        //     'domain_id',
        //     'price_plan_urgency_id',
        //     'price_plan_level_id',
        //     // 'price_plan_type_of_work_id',
        //     'price'
        // ]);

        $price_plan = \App\Models\PricePlan::with(['domain:currency_code','level','urgency'])->select('id','domain_id','price_plan_urgency_id','price_plan_level_id','price')->where('domain_id',$domain_id)->groupBy('id','domain_id','price_plan_urgency_id','price_plan_level_id','price')->get();

        // $price_plan_urgency_id = array_unique(array_column($price_plan, 'price_plan_urgency_id'));
        // $price_plan_level_id = array_unique(array_column($price_plan, 'price_plan_level_id'));
        // $price_plan_type_of_work_id = array_unique(array_column($price_plan, 'price_plan_type_of_work_id'));

        // $data['urgencies'] = \App\Models\PricePlanUrgency::whereIn('id', $price_plan_urgency_id)->pluck('name', 'id');
        // $data['levels'] = \App\Models\PricePlanLevel::whereIn('id', $price_plan_level_id)->pluck('name', 'id');
        // $data['type_of_works'] = \App\Models\PricePlanTypeOfWork::whereIn('id', $price_plan_type_of_work_id)->pluck('name', 'id');
        // $data['subjects'] = \App\Models\PricePlanSubject::pluck('name', 'id');
        // $data['addons'] = \App\Models\PricePlanAddOn::where('domain_id', $domain_id)->get(['id','name','amount']);

        return response()->json([
            'data' => $price_plan,
            'success' => true,
        ]);
    });


    Route::get('price-plan/{website_id}',[PricePlanController::class,'index'])->name('priceplan')->where(['website_id'=>'[0-9]+']);

    Route::group(['prefix'=>'customers'],function(){
        // Route::post('lead',[CustomerController::class,'lead']);
        Route::post('save',[CustomerController::class,'store']);
        Route::post('show',[CustomerController::class,'show']);
        Route::post('update',[CustomerController::class,'update']);
        Route::post('password/update',[CustomerController::class,'updatePassword']);
    });

    Route::group(['prefix'=>'leads'],function(){
        Route::post('save',[LeadController::class,'store']);
    });

    Route::group(['prefix'=>'orders'],function(){
        Route::post('get',[OrderController::class,'index']);
        Route::post('show',[OrderController::class,'show']);
        Route::post('show-edit',[OrderController::class,'showEdit']);
        Route::post('store',[OrderController::class,'store']);
        Route::post('update-order',[OrderController::class,'updateOrder']);
        Route::post('update-order-status',[OrderController::class,'updateOrderStatus']);
        Route::post('mark-modified',[OrderController::class,'markModified']);
        Route::post('mark-paid',[OrderController::class,'markPaid']);
    });

    Route::group(['prefix'=>'freelance'],function(){
        Route::post('register',[FreelanceController::class,'register']);
        Route::post('writers',[FreelanceController::class,'show']);
        Route::post('available-orders',[FreelanceController::class,'availableOrders']);
        Route::post('orders',[FreelanceController::class,'myOrders']);
        Route::post('show-order',[FreelanceController::class,'showOrder']);
        Route::post('apply',[FreelanceController::class,'apply']);
        Route::post('in-process',[FreelanceController::class,'inProcess']);
        Route::post('re-assigned',[FreelanceController::class,'reAssigned']);
        Route::post('submit',[FreelanceController::class,'submit']);
        Route::post('previous',[FreelanceController::class,'previous']);
        Route::post('transactions',[FreelanceController::class,'transaction']);
    });
});
