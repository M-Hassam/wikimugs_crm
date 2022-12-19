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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Lead</span>
                                @if(isset($model))
                                <form action="{{ route('leads.update',['lead'=>$model->id]) }}" method="post">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('leads.store') }}" method="post">
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
                                                        <select name="lead_status_id" class="form-control">
                                                            <option value="">Select Status</option>
                                                            @if(isset($statuses) && count($statuses))
                                                            @foreach($statuses as $status)
                                                            <option value="{{ $status->id }}" @if(isset($model) && $model->lead_status_id==$status->id) selected="" @endif>{{ $status->title ?? "" }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'lead_status_id'])
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" @if(isset($model) && $model->id) disabled="" @endif name="name" value="{{ old('name',$model->name ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Name</label>
                                                        @if(isset($model) && $model->id) <input type="hidden" name="name" value="{{ $model->name }}"> @endif
                                                        @include('layout.includes.form-error',['field'=>'name'])
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="email" @if(isset($model) && $model->id) disabled="" @endif value="{{ old('email',$model->email ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Email</label>
                                                        @if(isset($model) && $model->id) <input type="hidden" name="email" value="{{ $model->email }}"> @endif
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="phone" @if(isset($model) && $model->id) disabled="" @endif value="{{ old('phone',$model->phone ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Phone</label>
                                                        @if(isset($model) && $model->id) <input type="hidden" name="phone" value="{{ $model->phone }}"> @endif
                                                        @include('layout.includes.form-error',['field'=>'phone'])
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
                                                        <textarea class="form-control form-control-xl form-control-outlined" @if(isset($model) && $model->id) disabled="" @endif name="comment">{!! $model->comment ?? "" !!}</textarea>
                                                        <label class="form-label-outlined" for="outlined-normal">Remarks</label>
                                                        @if(isset($model) && $model->id) <input type="hidden" name="comment" value="{{ $model->comment }}"> @endif
                                                        @include('layout.includes.form-error',['field'=>'comment'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-8"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('leads.index') }}" class="btn btn-success"> Back</a>
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