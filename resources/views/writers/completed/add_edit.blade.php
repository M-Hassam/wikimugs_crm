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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Update @else Add @endif Order Status</span>
                                @if(isset($model))
                                <form action="{{ route('writers.assigned.update',['assigned'=>$model->id]) }}" method="post" enctype="multipart/form-data">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('writers.assigned.store') }}" method="post" enctype="multipart/form-data">
                                        @endif
                                        @csrf
                                        {{-- <div class="row">
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
                                        </div> --}}
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="lead_status_id" class="form-control">
                                                            <option value="4">Delivered</option>
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'lead_status_id'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">Add order files
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="file" name="files[]" required="" multiple>
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
                                                        <textarea class="form-control form-control-xl form-control-outlined" name="comment">{!! $model->comment ?? "" !!}</textarea>
                                                        <label class="form-label-outlined" for="outlined-normal">Remarks</label>
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
                                                <a href="{{ route('writers.assigned.index') }}" class="btn btn-success"> Back</a>
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