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
                                <form action="{{ route('writers.modified.update',['modified'=>$model->id]) }}" method="post" enctype="multipart/form-data">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('writers.modified.store') }}" method="post" enctype="multipart/form-data">
                                        @endif
                                        @csrf
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
                                            <div class="col-lg-8">Add files
                                                <fieldset id="order_attachments">
                                                    <div class="fieldwrapper row" id="field1">
                                                        <div class="col-6">
                                                            <input type="file" name='attachments[]' class="form-control" id="file1" required multiple>
                                                        </div>
                                                        <div class="col-6">
                                                            <i class="icon ni ni-trash-empty-fill removeFile" style="color: red"></i>
                                                            <input type="button" value="Add More" class="add add_more_btn btn btn-secondary btn-sm" id="add_file" />
                                                        </div>
                                                    </div>
                                                </fieldset>
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
                                                <a href="{{ route('writers.modified.index') }}" class="btn btn-success"> Back</a>
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