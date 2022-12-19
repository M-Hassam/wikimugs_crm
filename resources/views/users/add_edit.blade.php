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
                                <span class="preview-title-lg overline-title">@if(isset($model) && $model->id) Edit @else Add @endif User</span>
                                @if(isset($model))
                                <form action="{{ route('users.update',['user'=>$model->id]) }}" method="post" enctype="multipart/form-data">
                                    @method('PUT')
                                    @else
                                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                                        @endif
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    @php
                                                    $u_roles = isset($model['roles']) && count($model['roles']) ? $model['roles']->pluck('id')->toArray() : null;
                                                    @endphp
                                                    <div class="form-control-wrap">
                                                        <select name="role_ids[]" required="" multiple="multiple" class="form-select guest_writer_selection" data-placeholder="Select Role/s">
                                                            <option value="">Select Role</option>
                                                            @if(isset($roles) && count($roles))
                                                            @foreach($roles as $role)
                                                            {{-- <option value="{{ $role->id }}" @if(isset($model) && $model->role_id==$role->id) selected="" @endif>{{ $role->title }}
                                                            </option> --}}
                                                            <option value="{{ $role->id }}" @if(isset($u_roles) && count($u_roles) && in_array($role->id,$u_roles)) selected="" @endif>{{ $role->title }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        @include('layout.includes.form-error',['field'=>'role_ids'])
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
                                                        <select name="status" required="" class="form-control">
                                                            <option value="">Select Status</option>
                                                            <option value="1" @if(isset($model) && $model->status==1)  selected="" @endif>Active</option>
                                                            <option value="0" @if(isset($model) && $model->status==0)  selected="" @endif>Blocked</option>
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
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="name" value="{{ old('name',$model->name ?? "") }}">
                                                        <label class="form-label-outlined" for="outlined-normal">Name</label>
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
                                                        <input type="email" required="" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="email" value="{{ old('email',$model->email ?? "") }}">
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
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="password" value="">
                                                        <label class="form-label-outlined" for="outlined-normal">password</label>
                                                        @include('layout.includes.form-error',['field'=>'password'])
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2"></div>
                                        </div>
                                        <div class="guest_writer d-none">
                                            <div class="row mt-4">
                                                <div class="col-lg-2"></div>
                                                <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="address" value="{{ old('address',$model->address ?? "") }}">
                                                            <label class="form-label-outlined" for="outlined-normal">Address</label>
                                                            @include('layout.includes.form-error',['field'=>'address'])
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
                                                             <input type="file" class="form-control form-control-xl form-control-outlined" name="file"> 
                                                            {{-- <input type="file" class="form-control form-control-xl form-control-outlined" id="outlined-normal" name="files"> --}}
                                                            <label class="form-label-outlined" for="outlined-normal">Identity Verification</label>
                                                            @include('layout.includes.form-error',['field'=>'files'])
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2"></div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-8"></div>
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary">@if(isset($model) && $model->id) Update @else Add @endif</button>
                                                <a href="{{ route('users.index') }}" class="btn btn-success"> Back</a>
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

    @push('scripts')
    <script type="text/javascript">
        $(document).on('change','.guest_writer_selection', function() {
            let status_id = $(this).val();
            if($(this).val()==8){
                $('.guest_writer').removeClass('d-none');
            }else{
                $('.guest_writer').addClass('d-none');
            }
        });
    </script>
    @endpush