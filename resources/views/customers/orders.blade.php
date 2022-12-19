@extends('layout.app')


@section('content')

<div class="container-fluid">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview wide-md mx-auto">
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Customer Orders</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all customer orders</p>
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
                                        <th>Topic</th>
                                        <th>Total </th>
                                        <th>Discount</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model['domain']->name ?? "---" }}</td>
                                        <td>{{ $model->topic ?? "---" }}</td>
                                        <td>{{ $model->total_amount ?? "---" }}</td>
                                        <td>{{ $model->discount_amount ?? "---" }}</td>
                                        <td>{{ $model->grand_total_amount ?? "---" }}</td>
                                        <td>{{ $model->status->title ?? "---" }}</td>
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