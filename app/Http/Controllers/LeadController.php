<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LeadRequest;
use App\Models\{
    Lead,
    Order,
    Domain,
    LogModel,
    LeadStatus,
    LeadComment
};
use Exception;
use App\Mail\Lead\Followup;
use Illuminate\Support\Facades\Mail;
use App\Events\LogEvent;
use Event;
use Gate;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::allows('permission',42)){
            $data['models'] = Lead::with('domain','status')->orderBy('id','desc')->get();
            $data['statuses'] = LeadStatus::orderBy('id','desc')->get();
            Lead::where('is_new',0)->update(['is_new'=>1]);
            return view('leads/index',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::allows('permission',43)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['statuses'] = LeadStatus::orderBy('id','desc')->get();
            return view('leads.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\LeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadRequest $request)
    {
        if(Gate::allows('permission',43)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            $model = new Lead;
            $model->fill($data);
            $model->save();
            isset($request->comment) ? $model::saveComment($model->id,$model->domain_id,$request->comment) : "";

            $data = [
                'log_type_id'=>1,
                'user_id'=>auth()->user()->id ?? null,
                'domain_id'=>$model->domain_id ?? null,
                'general_id'=>$model->id ?? null,
                'slug'=>'lead-added',
                'description'=>auth()->user()->name.' has added new lead',
                'created_at'=>date('y-m-d h:i:s')
            ];

            Event::dispatch(new LogEvent($data));

            return redirect()->route('leads.index')->with('success','Lead added successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::allows('permission',47)){
            $lead = Lead::with('status', 'domain', 'comments', 'user', 'comments.user')->find($id);
            return response()->json(['status'=>1,'lead'=>$lead]);
        }else{
            abort(403);
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
        if(Gate::allows('permission',44)){
            $data['domains'] = Domain::orderBy('id','desc')->get();
            $data['statuses'] = LeadStatus::orderBy('id','desc')->get();
            $data['model'] = Lead::find($id);
            return view('leads.add_edit',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\LeadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeadRequest $request, $id)
    {
        if(Gate::allows('permission',44)){
            $data = $request->all();
            $data['created_by'] = auth()->user()->id;
            Lead::find($id)->update($data);
            return redirect()->route('leads.index')->with('success','Lead updated successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Gate::allows('permission',45)){
            Lead::find($id)->delete();
            return redirect()->route('leads.index')->with('success','Lead deleted successfully');
        }else{
            abort(403);
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
        if(Gate::allows('permission',48)){
            $data['models'] = LogModel::where('log_type_id',1)->where('general_id',$id)->orderBy('id','desc')->get();
            $data['lead_id'] = $id;
            return view('leads.log',$data);
        }else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        // if(Gate::allows('permission',34)){
            try{
                $model = Lead::with('status')->find($request->lead_id);
                if(!isset($request->comment_check)){
                    $model->lead_status_id = $request->status;
                    $model->save();

                    $data = [
                        'log_type_id'=>1 ,
                        'domain_id'=>$model->domain_id ?? null,
                        'user_id'=>auth()->user()->id ?? null,
                        'general_id'=>$model->id ?? null,
                        'slug'=>'lead-status-updated',
                        'description'=>auth()->user()->name.' changed lead status to '.LeadStatus::find($model->lead_status_id)->title ?? '',
                        'created_at'=>date('y-m-d h:i:s')
                    ];
                    LogModel::insert($data);
                }

                isset($request->comment) ? $model::saveComment($model->id,$model->domain_id,$request->comment) : "";

            // event(new LogEvent($data));

                return $request->ajax() ? response()->json(['status'=>1]) : redirect()->back()->with('success','Status updated successfully');

            }catch(Exception $ex){
                return response()->json(['exception'=>$ex->getMessage(),'line'=>$ex->getLine()]);
            }
        // }else{
        //     abort(403);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\LeadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function mail(Request $request)
    {
        if(Gate::allows('permission',46)){
            if($request->has('lead_email')){
                $model = Lead::find($request->lead_id);
                Mail::to($model->email)
            // ->cc($moreUsers)
                ->send(new Followup($request->email_content));

                $data = ['log_type_id'=>1,'user_id'=>auth()->user()->id ?? null,'domain_id'=>$model->domain_id ?? null,'general_id'=>$model->id ?? null,
                'slug'=>'lead-follow-up-email','description'=>auth()->user()->name.' has sent follow up email','created_at'=>date('y-m-d h:i:s')];
                LogModel::insert($data);
            }
            return redirect()->back()->with('success','Follow up email sent successfully');
        }else{
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        $data['leads'] = Lead::where('is_new',0)->where('lead_status_id',1)->count();
        $data['payment_awaiting_orders'] = Order::where('is_new',0)->where('status_id',1)->count();
        $data['pending_orders'] = Order::where('is_new',0)->where('status_id',2)->count();
        $data['assigned_orders'] = Order::where('is_new',0)->where('status_id',3)->count();
        $data['writer_delivery_orders'] = Order::where('is_new',0)->where('status_id',4)->count();
        $data['delivered_orders'] = Order::where('is_new',0)->where('status_id',5)->count();
        $data['modified_orders'] = Order::where('is_new',0)->where('status_id',6)->count();
        $data['completed_orders'] = Order::where('is_new',0)->where('status_id',7)->count();
        $data['canceled_orders'] = Order::where('is_new',0)->where('status_id',8)->count();
        if(in_array(auth()->user()->role_id,['4','5'])){
            $data['writer_assigned_orders'] = Order::where('writer_id',auth()->user()->id)
            ->where(['status_id'=>3,'is_reassigned'=>0,'is_new'=>0])
            ->count();

            $data['writer_modification_orders'] = Order::where('writer_id',auth()->user()->id)
            ->where(['status_id'=>3,'is_reassigned'=>1,'is_new'=>0])
            ->count();
        }
        return response()->json([
            'status' => 1,
            'message' =>"success",
            'data' => $data
        ]);
    }
}
