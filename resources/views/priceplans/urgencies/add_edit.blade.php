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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Price plan Urgency</span>
                                @if(isset($model))
                                <form action="{{ route('priceplan.urgencies.update',['urgency'=>$model->id]) }}" method="post">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('priceplan.urgencies.store') }}" method="post">
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="name" value="{{ old('name',$model->name ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Title</label>
                                                        @include('layout.includes.form-error',['field'=>'name'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        {{-- <div class="row mt-4">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="amount" value="{{ old('amount',$model->amount ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Amount</label>
                                                        @include('layout.includes.form-error',['field'=>'amount'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div> --}}
                                        <div class="row mt-4">
                                            <div class="col-lg-8"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('priceplan.urgencies.index') }}" class="btn btn-success"> Back</a>
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