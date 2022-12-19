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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Coupon</span>
                                @if(isset($model))
                                <form action="{{ route('coupons.update',['coupon'=>$model->id]) }}" method="post">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('coupons.store') }}" method="post">
                                        @endif
                                        @csrf
                                        <div class="row row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="coupon_type_id" class="form-control">
                                                            <option value="">Select Discount Type</option>
                                                            @if(isset($coupon_types) && count($coupon_types))
                                                            @foreach($coupon_types as $coupon_type)
                                                            <option value="{{ $coupon_type->id }}" @if(isset($model) && $model->coupon_type_id==$coupon_type->id) selected="" @endif>{{ $coupon_type->title }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'coupon_type_id'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="status" class="form-control">
                                                            <option value="">Select Status</option>
                                                            <option value="1" @if(isset($model) && $model->status==1) selected="" @endif>Active</option>
                                                            <option value="0" @if(isset($model) && $model->status==0) selected="" @endif>Not Active</option>
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'status'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="discount" value="{{ old('discount',$model->discount ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Discount</label>
                                                        @include('layout.includes.form-error',['field'=>'discount'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="code" value="{{ old('code',$model->code ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Code</label>
                                                        @include('layout.includes.form-error',['field'=>'code'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="date" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="start_date" value="{{ old('start_date',$model->start_date ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Start Date</label>
                                                        @include('layout.includes.form-error',['field'=>'start_date'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="date" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="end_date" value="{{ old('end_date',$model->end_date ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">End Date</label>
                                                        @include('layout.includes.form-error',['field'=>'end_date'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="limit" value="{{ old('limit',$model->limit ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">limit</label>
                                                        @include('layout.includes.form-error',['field'=>'limit'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="per_user" value="{{ old('per_user',$model->per_user ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Per User</label>
                                                        @include('layout.includes.form-error',['field'=>'per_user'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <textarea class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="description">{{ $model->description ?? "" }}</textarea>
                                                        <label class="form-label-outlined" for="outlined-normal">Description</label>
                                                        @include('layout.includes.form-error',['field'=>'description'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4 row-center">
                                            <div class="col-lg-12"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('coupons.index') }}" class="btn btn-success"> Back</a>
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