@extends('layout.app')


@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview wide-md mx-auto">
                <div class="nk-block nk-block-lg">
                    <div class="card card-preview">
                        <div class="card-inner">
                            <div class="preview-block">
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Customer</span>
                                @if(isset($model))
                                <form action="{{ route('customers.update',['customer'=>$model->id]) }}" method="post">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('customers.store') }}" method="post">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="domain_id" class="form-control">
                                                            <option value="">Select Domain</option>
                                                            @if(isset($domains) && count($domains))
                                                            @foreach($domains as $domain)
                                                            <option value="{{ $domain->id }}" @if(isset($model) && $model->domain_id==$domain->id) selected="" @endif>{{ $domain->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'domain_id'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="status" class="form-control">
                                                            <option value="">Select Status</option>
                                                            <option value="1" @if(isset($model) && $model->status==1) selected="" @endif>Active</option>
                                                            <option value="0" @if(isset($model) && $model->status==0) selected="" @endif>Blocked</option>
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'status'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="first_name" value="{{ old('first_name',$model->first_name ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Name</label>
                                                        @include('layout.includes.form-error',['field'=>'first_name'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="email" value="{{ old('email',$model->email ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Email</label>
                                                        @include('layout.includes.form-error',['field'=>'email'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="phone" value="{{ old('phone',$model->phone ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Phone</label>
                                                        @include('layout.includes.form-error',['field'=>'phone'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-8"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('customers.index') }}" class="btn btn-success"> Back</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection