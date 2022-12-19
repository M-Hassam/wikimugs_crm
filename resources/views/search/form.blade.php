@extends('layout.app')


@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview wide-lg mx-auto">
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="preview-block">
                                <span class="preview-title-lg overline-title">Search Order</span>
                                <form action="{{ route('orders.search.index') }}" method="get">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="name" value="{{ old('name',$model->name ?? "") }}">
                                                    <label class="form-label-outlined" for="outlined-normal">Name</label>
                                                    @include('layout.includes.form-error',['field'=>'name'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="email" value="{{ old('email',$model->email ?? "") }}">
                                                    <label class="form-label-outlined" for="outlined-normal">Email</label>
                                                    @include('layout.includes.form-error',['field'=>'email'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="customer_id" value="{{ old('customer_id',$model->customer_id ?? "") }}">
                                                    <label class="form-label-outlined" for="outlined-normal">Customer ID</label>
                                                    @include('layout.includes.form-error',['field'=>'customer_id'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="order_id" value="{{ old('order_id',$model->order_id ?? "") }}">
                                                    <label class="form-label-outlined" for="outlined-normal">Order ID</label>
                                                    @include('layout.includes.form-error',['field'=>'order_id'])
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-lg-8"></div>
                                        <div class="col-lg-4">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-inner">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>Order No</th>
                                        <th>Domain</th>
                                        <th scope="col">Customer ID</th>
                                        <th scope="col">Customer Name</th>
                                        <th>UserArea</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && $models->count() > 0)
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model->order_no ?? "---" }}</td>
                                        <td>{{ $model['domain']->name ?? "---" }}</td>
                                        <td>{{ $model->customer_id ?? "---" }}</td>
                                        <td>{{ isset($model['customer']) ? $model['customer']->first_name : "---" }}</td>
                                        <td>
                                            {{-- <form name="eoffice_form" target="_blank" action="{{ $model->domain->url."userarea/user-login" }}" method="post"> --}}
                                            <form name="eoffice_form" target="_private" action="http://localhost/academics1/website1/userarea/user-login" method="post">
                                                <input type="hidden" name="email" value="{{ $model->customer->email }}">
                                            </form>
                                            {{-- <a href="#" onClick="document.forms['eoffice_form'].submit(); return false;" >UserArea</a> --}}
                                            <a href="{{ $model['domain']->url.base64_encode($model->id).'/preview' }}" target="_blank" class="" data-customer-id="{{ $model->id }}" title="User area" data-toggle="tooltip">
                                                <em class="icon ni ni-user"></em>
                                                <span>Userarea</span>
                                            </a>
                                        </td>
                                        <td>{{ formattedTimeDate($model->created_at) ?? "---" }}</td>
                                        <td>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right" style="">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a href="javascript:;" data-id="{{ $model->id }}" class="assign_to_writer">
                                                                <em class="icon ni ni-user-add"></em>
                                                                <span>Assign to Writer</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" class="view_order" data-id={{ $model->id }}>
                                                                <em class="icon ni ni-eye"></em>
                                                                <span>Preview</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('orders').'/'.$model->id }}/logs">
                                                                <em class="icon ni ni-file-docs"></em>
                                                                <span>Logs</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('orders').'/delete/'.$model->id }}">
                                                                <em class="icon ni ni-trash-fill"></em>
                                                                <span>Delete</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>No data found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{-- {!! $models->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection