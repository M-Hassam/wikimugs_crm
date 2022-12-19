@extends('layout.app')


@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview wide-lg mx-auto">
                <div class="nk-block nk-block-sm">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Customers</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all customers</p>
                                </div>
                            </div>
                            {{-- <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                <a href="{{ route('customers.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card card-preview">
                        <div class="card-inner">
                            <table class="datatable-init table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Domain</th>
                                        <th>Serial No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model['domain']->name ?? "---" }}</td>
                                        <td>{{ $model->serial_no ?? "---" }}</td>
                                        <td>{{ $model->first_name ?? "---" }}</td>
                                        {{-- <td>{{ $model->last_name ?? "---" }}</td> --}}
                                        <td>{{ $model->email ?? "---" }}</td>
                                        <td>{{ $model->phone ?? "---" }}</td>
                                        {{-- <td>@if($model->status==0) <label class="badge badge-danger">Blocked</label> @else <label class="badge badge-success">Active</label> @endif</td> --}}
                                        <td>{{ isset($model->created_at) ? formattedDate($model->created_at) : "---" }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                @can('permission',36)
                                                <a href="{{ route('customers.edit',['customer'=>$model->id]) }}" title="Edit" data-toggle="tooltip">
                                                    <em class="icon ni ni-pen2"></em>
                                                </a>
                                                @endcan
                                                @can('permission',38)
                                                <a href="javascript::" class="change_password ml-2" data-customer-id="{{ $model->id }}" title="Update Password" data-toggle="tooltip">
                                                    <em class="icon ni ni-repeat-fill"></em>
                                                </a>
                                                @endcan
                                                @can('permission',39)
                                                <a href="{{ route('customers.show',['customer'=>$model->id]) }}" class="ml-2" data-customer-id="{{ $model->id }}" title="View Orders" data-toggle="tooltip">
                                                    <em class="icon ni ni-sign-dollar"></em>
                                                </a>
                                                @endcan
                                                @can('permission',40)
                                                <a href="{{ $model['domain']->url.'userarea/crm-login/'.$model->email }}" target="_blank" class="ml-2" data-customer-id="{{ $model->id }}" title="User area" data-toggle="tooltip">
                                                    <em class="icon ni ni-user"></em>
                                                </a>
                                                @endcan
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
@include('modals.customers.password')

@endsection

@push('scripts')

<script type="text/javascript">
    $(document).on('click','.change_password',function(){
        var con = confirm('Are you sure you want to update customer password?');
        if(con == true){
            $('#change_password').modal('toggle');
            $('.customer_id').val($(this).data('customer-id'));
        }

        $('#password, #confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#update_pass_btn').removeClass('d-none');
            } else {
                $('#update_pass_btn').addClass('d-none');
            }
        });
    });
</script>

@endpush