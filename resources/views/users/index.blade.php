@extends('layout.app')


@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview wide-lg mx-auto">
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Users</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all users</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                @can('permission',90)
                                                <a href="{{ route('users.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a>
                                                @endcan
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-preview">
                        <div class="card-inner">
                            <table class="datatable-init table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Serial No </th>
                                        <th>Role</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model->serial_no ?? "---" }}</td>
                                        <td>{{ $model->dfsds ?? "---" }}</td>
                                        <td>{{ $model->name ?? "---" }}</td>
                                        <td>{{ $model->email ?? "---" }}</td>
                                        <td>{{ $model->phone ?? "---" }}</td>
                                        <td>@if($model->status==0) <label class="badge badge-danger">Blocked</label> @else <label class="badge badge-success">Active</label> @endif</td>
                                        <td>
                                            <div class="action-buttons">
                                                @can('permission',91)
                                                <a href="{{ route('users.edit',['user'=>$model->id]) }}" title="Edit" data-toggle="tooltip">
                                                    <em class="icon ni ni-pen2"></em>
                                                </a>
                                                @endcan
                                                @can('permission',92)
                                                <form action="{{ route('users.destroy',['user'=>$model->id]) }}" method="post" class="ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="" title="Delete" data-toggle="tooltip" onclick="this.closest('form').submit();return false;">
                                                        <em class="icon ni ni-trash"></em>
                                                    </a>
                                                </form>
                                                @endcan
                                                @if($model->role_id==8)
                                                @can('permission',93)
                                                <a href="{{ route('users.transactions',['user'=>$model->id]) }}" title="View Transactions" class="ml-2" data-toggle="tooltip">
                                                    <em class="icon ni ni-sign-dollar"></em>
                                                </a>
                                                @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection