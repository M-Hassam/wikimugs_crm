<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PricePlanController;
use App\Http\Controllers\PricePlanLevelController;
use App\Http\Controllers\PricePlanLevelLevelController;
use App\Http\Controllers\PricePlanNoOfPagesController;
use App\Http\Controllers\PricePlanSubjectController;
use App\Http\Controllers\PricePlanTypeOfWorkController;
use App\Http\Controllers\PricePlanTypeOfWorkLevelController;
use App\Http\Controllers\PricePlanUrgencyController;
use App\Http\Controllers\PricePlanUrgencyLevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
// use App\Http\Controllers\TierController;
use App\Models\PricePlanTypeOfWork;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/clear-all',function(){
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    die('cleared');
});

Route::get('add-admin',function(){
    $user = User::find(1);
    $user->role_id = 1;
    $user->email = 'bjohnson@example.com';
    $user->password = \Hash::make('123456');
    $user->save();
    dd('updated');
});
Route::get('add-writer',function(){
    $user = User::find(2);
    $user->role_id = 4;
    $user->email = 'writer@example.com';
    $user->password = \Hash::make('123456');
    $user->save();
    dd('updated');
});
Route::get('add-writer-lead',function(){
    $user->role_id = 4;
    $user = User::find(3);
    $user->email = 'writerlead@example.com';
    $user->password = \Hash::make('123456');
    $user->save();
    dd('updated');
});

Route::get('/spatie_test',function(){
    $role = Role::find(1);
    dd($role);
    $permission = Permission::create(['name' => 'edit articles']);
    $role->givePermissionTo($permission);
    dd('done');
});

Route::get('/spatie-user',function(){
    $user = User::find(1);
    $user->givePermissionTo('edit articles');
    dd('done');
});

Route::get('/spatie-view',function(){
    return view('welcome');
});

Route::get('pass',function(){
    dd(\Hash::make('12345678'));
});

Route::get('file-import-export', [UserController::class, 'fileImportExport']);
Route::get('file-import-view', [UserController::class, 'fileImportimport'])->name('file-import-view');
Route::post('file-import', [UserController::class, 'fileImport'])->name('file-import');
Route::get('file-export', [UserController::class, 'fileExport'])->name('file-export');

Route::get('/', [LoginController::class,'create']);
Route::get('/login', [LoginController::class,'create']);
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::group(['middleware' => ['auth','web']], function () {
    Route::get('logout',function(){
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users',UserController::class);
    Route::get('users/transactions/{user}',[UserController::class,'transaction'])->name('users.transactions');
    Route::get('users/transactions/{user}/create',[UserController::class,'createTransaction'])->name('users.transaction.create');
    Route::post('users/transactions/{user}/store',[UserController::class,'storeTransaction'])->name('users.transaction.store');
    Route::get('users/transactions/{transaction}/edit',[UserController::class,'editTransaction'])->name('users.transaction.edit');
    Route::post('users/transactions/{transaction}/update',[UserController::class,'updateTransaction'])->name('users.transaction.update');
    Route::namespace('App\Http\Controllers')->group(function(){

        Route::resource('regions',RegionController::class);
        
        Route::resource('tiers',TierController::class);

        Route::get('domains/autocomplete', [\App\Http\Controllers\DomainController::class, 'autocomplete'])->name('domains.autocomplete');
        Route::resource('domains',DomainController::class);

        Route::group(['prefix'=>'leads','as'=>'leads.'],function(){
            Route::resource('statuses',LeadStatusController::class);
            Route::resource('channels',LeadChannelController::class);
        });
        
        Route::resource('leads',LeadController::class);
        Route::get('leads/{lead}/logs',[\App\Http\Controllers\LeadController::class,'log'])->name('leads.logs');
        Route::post('leads/status',[\App\Http\Controllers\LeadController::class,'status'])->name('leads.status');
        Route::post('leads/follow_mail',[\App\Http\Controllers\LeadController::class,'mail'])->name('leads.follow_mail');
        Route::post('notification',[\App\Http\Controllers\LeadController::class,'notification'])->name('customers.notification');


        // Route::resource('roles',RoleController::class);
        Route::resource('permissions',PermissionController::class);
        Route::resource('roles',RoleController::class);
        
        Route::resource('coupon-types',CouponTypeController::class)->only('index');
        
        Route::resource('coupons',CouponController::class);
        
        Route::resource('customers',CustomerController::class);
        Route::post('customers/update-password',[\App\Http\Controllers\CustomerController::class,'updatePassword'])->name('customers.update_password');
    });

    Route::group(['prefix'=>'price-plan','as'=>'priceplan.'],function(){
        Route::resource('type-of-works',PricePlanTypeOfWorkController::class);
        Route::resource('levels',PricePlanLevelController::class);
        Route::resource('urgencies',PricePlanUrgencyController::class);
    });

    Route::get('price-plans/export/{id}', [PricePlanController::class, 'export'])->name('price_plans.export');
    Route::post('price-plans/import', [PricePlanController::class, 'import'])->name('price_plans.import');
    Route::get('price-plans/getCount', [PricePlanController::class, 'getCount'])->name('price_plans.getCount');
    Route::post('price-plans/get', [PricePlanController::class, 'get'])->name('price_plans.get');
    Route::resource('price-plans', PricePlanController::class);
    Route::get('price-plans/edit/{order}', [PricePlanController::class, 'edit'])->name('price-plans.edit');
    Route::get('price-plans/delete/{price_plan_id}', [PricePlanController::class, 'destroy'])->name('price-plans.destroy');

    //price plan levels
    Route::get('price-plan-levels/autocomplete', [\App\Http\Controllers\PricePlanLevelController::class, 'autocomplete'])->name('price_plan_levels.autocomplete');
    Route::get('price-plan-levels/order/autocomplete', [\App\Http\Controllers\PricePlanLevelController::class, 'autocomplete_order'])->name('price_plan_levels.order.autocomplete');
    Route::resource('price-plans-levels', \App\Http\Controllers\PricePlanLevelController::class);
    //price plan levels

    //price plan levels
    Route::get('price-plan-styles/autocomplete', [\App\Http\Controllers\PricePlanStyleController::class, 'autocomplete'])->name('price_plan_styles.autocomplete');
    Route::resource('price-plans-styles', \App\Http\Controllers\PricePlanStyleController::class);
    //price plan levels

    //price plan urgencies
    Route::get('price-plan-urgencies/autocomplete', [\App\Http\Controllers\PricePlanUrgencyController::class, 'autocomplete'])->name('price_plan_urgencies.autocomplete');
    Route::get('price-plan-urgencies/order/autocomplete', [\App\Http\Controllers\PricePlanUrgencyController::class, 'autocomplete_order'])->name('price_plan_urgencies.order.autocomplete');
    Route::resource('price-plan-urgencies', \App\Http\Controllers\PricePlanUrgencyController::class);
    //price plan urgencies

    
    //price plan type of work
    Route::get('price-plan-type-of-works/autocomplete', [\App\Http\Controllers\PricePlanTypeOfWorkController::class, 'autocomplete'])->name('price_plan_type_of_works.autocomplete');
    Route::get('price-plan-type-of-works/order/autocomplete', [\App\Http\Controllers\PricePlanTypeOfWorkController::class, 'autocomplete_order'])->name('price_plan_type_of_works.order.autocomplete');
    Route::resource('price-plan-type-of-works', \App\Http\Controllers\PricePlanTypeOfWorkController::class);
    //price plan type of work

    //price plan type of work
    Route::get('price-plan-no-of-pages/autocomplete', [PricePlanNoOfPagesController::class, 'autocomplete'])->name('price_plan_no_of_pages.autocomplete');
    Route::resource('price-plan-no-of-pages', PricePlanNoOfPagesController::class);
    //price plan type of work

    //price plan type of work
    Route::get('price-plan-subjects/autocomplete', [PricePlanSubjectController::class, 'autocomplete'])->name('price_plan_subjects.autocomplete');
    Route::resource('price-plan-subjects', PricePlanSubjectController::class);
    //price plan type of work

    //order
    Route::get('orders/view/order', [OrderController::class, 'view_order'])->name('orders.view_order');
    Route::get('orders/convert_to_order/{domain}/{lead}', [OrderController::class, 'convert_to_order'])->name('orders.convert_to_order');
    Route::post('orders/calculate', [OrderController::class, 'calculate'])->name('orders.calculate');
    Route::post('orders/storeMedia', [OrderController::class, 'storeMedia'])->name('orders.storeMedia');
    Route::get('orders/statuses', [OrderController::class, 'statuses'])->name('orders.statuses');
    Route::post('orders/get', [OrderController::class, 'get'])->name('orders.get');
    Route::post('orders/store_customer', [OrderController::class, 'store_with_customer'])->name('orders.store.customer');
    Route::group(['prefix'=>'orders','as'=>'orders.'],function(){
        Route::get('payment-awaiting',[OrderController::class,'payment_awaiting'])->name('payment_awaiting');
        Route::get('pending',[OrderController::class,'pending'])->name('pending');
        Route::get('assigned',[OrderController::class,'assigned'])->name('assigned');
        Route::get('writer_delivery',[OrderController::class,'writer_delivery'])->name('writer_delivery');
        Route::get('delivered',[OrderController::class,'delivered'])->name('delivered');
        Route::get('modified',[OrderController::class,'modified'])->name('modified');
        Route::get('completed',[OrderController::class,'completed'])->name('completed');
        Route::get('canceled',[OrderController::class,'canceled'])->name('canceled');
        Route::get('search',[SearchController::class,'index'])->name('search.index');
    });
    Route::resource('orders', OrderController::class);
    Route::get('orders/delete/{order}', [OrderController::class, 'destroy'])->name('orders.get');
    Route::get('orders/status/change/{order}', [OrderController::class, 'status_change'])->name('orders.change.status');
    Route::get('orders/{order}/logs',[\App\Http\Controllers\OrderController::class,'log'])->name('orders.logs');
    Route::post('order-payment-status', [\App\Http\Controllers\OrderController::class, 'payment_status'])->name('payment_status');
    Route::post('order/follow_mail',[\App\Http\Controllers\OrderController::class,'followup_mail'])->name('orders.follow_mail');
    Route::post('order/discount',[\App\Http\Controllers\OrderController::class,'discount'])->name('orders.discount');
    Route::post('order/comment',[\App\Http\Controllers\OrderController::class,'comment'])->name('orders.comment');
    Route::post('order/file',[\App\Http\Controllers\OrderController::class,'file'])->name('orders.file');
    Route::post('order/send',[\App\Http\Controllers\OrderController::class,'send'])->name('orders.send');
    Route::get('orders/{order}/markcomplete',[\App\Http\Controllers\OrderController::class,'mark_complete'])->name('orders.markcomplete');
    Route::get('orders/remove-writer/{order}', [OrderController::class, 'remove_writer'])->name('orders.remove_writer');
    //order

    Route::group(['prefix'=>'writers','as'=>'writers.'],function(){
        Route::resource('assigned',\App\Http\Controllers\Writer\AssignOrderController::class);
        Route::get('autocomplete', [\App\Http\Controllers\WriterOrderController::class, 'autocomplete'])->name('autocomplete');
        Route::get('freelanceautocomplete', [\App\Http\Controllers\WriterOrderController::class, 'freelanceAutocomplete'])->name('freelanceautocomplete');
        Route::get('applications', [\App\Http\Controllers\WriterOrderController::class, 'freelanceApplication'])->name('application');
        Route::post('assign_order', [\App\Http\Controllers\WriterOrderController::class, 'assign_order'])->name('assign_order');
        Route::post('re_assign_order', [\App\Http\Controllers\WriterOrderController::class, 're_assign_order'])->name('re_assign_order');
        
        Route::resource('delivered',\App\Http\Controllers\Writer\DeliveredController::class);
        Route::resource('modified',\App\Http\Controllers\Writer\ModifiedController::class);
        Route::resource('completed',\App\Http\Controllers\Writer\CompletedController::class);
        Route::resource('canceled',\App\Http\Controllers\Writer\CanceledController::class);
    });

    Route::group(['prefix'=>'writers-qa','as'=>'writersqa.'],function(){
        Route::resource('orders',\App\Http\Controllers\Writer\QaAssignOrderController::class);
    });


    Route::get('/mailable', function () {
        // $invoice = App\Models\Invoice::find(1);

         // Mail::to($customer->email)
                            // ->queue(new CustomerSignUp($email_data));

        $email_data['customer'] = \App\Models\Customer::find(1);

        return new App\Mail\CustomerSignUp($email_data);
    });

});
