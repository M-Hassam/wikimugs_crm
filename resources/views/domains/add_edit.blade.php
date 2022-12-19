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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Domain</span>
                                @if(isset($model))
                                <form action="{{ route('domains.update',['domain'=>$model->id]) }}" method="post">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('domains.store') }}" method="post">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <select name="region_id" class="form-control">
                                                            <option value="">Select Region</option>
                                                            @if(isset($regions) && count($regions))
                                                            @foreach($regions as $region)
                                                            <option value="{{ $region->id }}" @if(isset($model) && $model->region_id==$region->id) selected="" @endif>{{ $region->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'region_id'])
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
                                                        <select name="tier_id" class="form-control">
                                                            <option value="">Select Tier</option>
                                                            @if(isset($tiers) && count($tiers))
                                                            @foreach($tiers as $tier)
                                                            <option value="{{ $tier->id }}"  @if(isset($model) && $model->tier_id==$tier->id) selected="" @endif>{{ $tier->name }}
                                                            </option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'tier_id'])
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="name" value="{{ old('name',$model->name ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Title</label>
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="code" value="{{ old('code',$model->code ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Code</label>
                                                        @include('layout.includes.form-error',['field'=>'code'])
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="url" value="{{ old('url',$model->url ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">url</label>
                                                        @include('layout.includes.form-error',['field'=>'url'])
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="currency" value="{{ old('currency',$model->currency ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Currency</label>
                                                        @include('layout.includes.form-error',['field'=>'currency'])
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="currency_code" value="{{ old('currency_code',$model->currency_code ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Currency Code</label>
                                                        @include('layout.includes.form-error',['field'=>'currency_code'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-8"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('domains.index') }}" class="btn btn-success"> Back</a>
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