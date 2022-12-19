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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif Role</span>
                                @if(isset($model))
                                <form action="{{ route('roles.update',['role'=>$model->id]) }}" method="post">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('roles.store') }}" method="post">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="title" value="{{ old('title',$model->title ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Title</label>
                                                        @include('layout.includes.form-error',['field'=>'title'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        @php
                                        $given_permissions = isset($model['permissions']) ?  $model['permissions']->pluck('id')->toArray() : null;
                                        @endphp
                                        @if(isset($permissions) && count($permissions))
                                        <div class="row mt-2">
                                            @foreach($permissions as $permission)
                                            <div class="col-lg-2">
                                                <input type="checkbox" id="permissions-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" @if(isset($given_permissions) && count($given_permissions) && in_array($permission->id,$given_permissions))checked="" @endif>
                                                <label for="permissions-{{ $permission->id }}">{{ $permission->title }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <div class="row mt-4">
                                            <div class="col-lg-8"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('roles.index') }}" class="btn btn-success"> Back</a>
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