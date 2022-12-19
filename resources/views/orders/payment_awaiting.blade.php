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
                                <h3 class="nk-block-title page-title">Payment Awaitinng Orders</h3>
                                <div class="nk-block-des text-soft">
                                    <p>You have total orders {{ $orders_count ?? 0 }} </p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                @can('permission',51)
                                                <a href="{{ route('orders.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a>
                                                @endcan
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-preview">
                        <div class="card-inner position-relative">
                            <div class="card-title-group">
                                <div class="card-tools">
                                </div>
                                <div class="card-tools mr-n1">
                                    <ul class="btn-toolbar gx-1">
                                        <li>
                                            <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                        </li>
                                        <li class="btn-toolbar-sep"></li>
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <div class="dot dot-primary"></div>
                                                    <em class="icon ni ni-filter-alt"></em>
                                                </a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <form action="{{ route('orders.payment_awaiting') }}" method="get">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">Select Domain</label>
                                                                        <select id="domain_id" name="domain_id" class="form-select form-select-sm select2-hidden-accessible DomainSelect" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                                                            <option value="" data-select2-id="6">Select Domain</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-1">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-secondary">Filter</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-search search-wrap" data-search="search">
                                <div class="card-body">
                                    <div class="search-content">
                                        <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                        <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search by domain">
                                        <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-inner">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S No</th>
                                        <th>Order No</th>
                                        <th>Domain</th>
                                        <th scope="col">Customer ID</th>
                                        <th scope="col">Customer Name</th>
                                        <th>Discount</th>
                                        <th>Grand Total</th>
                                        <th>Actual Time</th>
                                        <th>Order Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && $models->count() > 0)
                                    @foreach($models as $model)
                                    <tr @if($model->is_new==0) class="text-primary" @endif>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model->order_no ?? "---" }}</td>
                                        <td>{{ $model['domain']->name ?? "---" }}</td>
                                        <td>{{ $model->customer_id ?? "---" }}</td>
                                        <td>{{ isset($model['customer']) ? $model['customer']->first_name : "---" }}</td>
                                        <td>
                                            @can('permission',59)
                                            <a href="javascript:;" class="manual_discount" data-id="{{ $model->id }}" data-order-no="{{ $model->order_no }}" data-price="{{ $model->grand_total_amount }}" data-addon-price="{{ $model->addons_amount }}" data-price-without-addon="{{ $model->discount_amount }}">{{ $model->manual_discount_amount && $model->manual_discount_amount=="0.5" ? "0" :  $model->manual_discount_amount }}
                                            </a>
                                            @else
                                            <a href="javascript:;">{{ $model->manual_discount_amount && $model->manual_discount_amount=="0.5" ? "0" :  $model->manual_discount_amount }}
                                            </a>
                                            @endcan
                                        </td>
                                        <td>{{ $model->grand_total_amount ?? "---" }}</td>
                                        <td>{{ isset($model['urgency']) ? $model['urgency']->name : "---" }}</td>
                                        <td>{{ formattedTimeDate($model->created_at) }}</td>
                                        <td>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right" style="">
                                                    <ul class="link-list-opt no-bdr">
                                                        @can('permission',52)
                                                        <li>
                                                            <a href="javascript:;" data-id="{{ $model->id }}" class="update_payment">
                                                                <em class="icon ni ni-amazon-pay"></em>
                                                                <span>Update Payment</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                        @can('permission',53)
                                                        <li>
                                                            <a href="{{ url('orders').'/'.$model->id }}/edit">
                                                                <em class="icon ni ni-pen2"></em>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                        @can('permission',54)
                                                        <li>
                                                            <a href="javascript:;" data-id="{{ $model->id }}" class="follow_up">
                                                                <em class="icon ni ni-mail"></em>
                                                                <span>Follow Up</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                        @can('permission',55)
                                                        <li>
                                                            <a href="javascript:;" class="view_order" data-id={{ $model->id }}>
                                                                <em class="icon ni ni-eye"></em>
                                                                <span>Preview</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                        @can('permission',56)
                                                        <li>
                                                            <a href="{{ url('orders').'/'.$model->id }}/logs">
                                                                <em class="icon ni ni-file-docs"></em>
                                                                <span>Logs</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                        @can('permission',57)
                                                        <li>
                                                            <a href="{{ url('orders').'/delete/'.$model->id }}">
                                                                <em class="icon ni ni-trash-fill"></em>
                                                                <span>Delete</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                        @can('permission',58)
                                                        <li>
                                                            <a href="{{ $model['domain']->url.base64_encode($model->id).'/preview' }}" target="_blank" class="" data-customer-id="{{ $model->id }}" title="User area" data-toggle="tooltip">
                                                                <em class="icon ni ni-user"></em>
                                                                <span>Userarea</span>
                                                            </a>
                                                        </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {!! $models->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@include('modals.orders.modal')

@push('scripts')
<link rel="stylesheet" href="{{ asset('template/src/assets/css/editors/summernote.css') }}">
<script src="{{ asset('template/src/assets/js/libs/editors/summernote.js') }}"></script>
<script src="{{ asset('template/src/assets/js/editors.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function(){
        DomainSelect();

        $(document).on('click','.view_order', function() {
            let order_id = $(this).data('id');
            showOrder(order_id);
        });

        $(document).on('submit','#updatePaymentForm', function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('payment_status') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (!data.errors) {
                        toastr.success(data.message);
                        $('#OrderModal').modal('hide');
                        $('#updatePaymentForm').trigger("reset");
                        alert('Payment staus updated');
                        location.reload();
                    } else {
                        //validation errors

                    }
                },
                error: function (response) {
                    resetValidationErrors($('#updatePaymentForm'))
                    handleValidationErrors($('#updatePaymentForm'), response.responseJSON.errors)
                }
            });
        });

        $(document).on('click','.update_payment', function() {
            $('.order_modal_title').html('Update Payment Status')
            let response = `<form id="updatePaymentForm">
            <div class="modal-body">
            <div class="row g-4">
            <div class="col-lg-6">
            <div class="form-group" >
            <label class="form-label">Select Payment Status<span class="text-danger">*</span></label>
            <div class="form-control-wrap">
            <select name="payment_status" class="form-select form-control">
            <option value='1'>Paid</option><option value='0'>Not Paid</option>
            </select>
            <span class="error"></span>
            </div>
            <input type="hidden" name='order_id' value="${$(this).data('id')}">
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Save</button>
            </div>
            </div>
            </div>
            </form>`;

            $('.modal-body').html(response);
            $('#OrderModal').modal('toggle');
        });

        $(document).on('submit','#followUpEmailForm', function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('orders.follow_mail') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (!data.errors) {
                        toastr.success(data.message);
                        $('#OrderModal').modal('hide');
                        $('#followUpEmailForm').trigger("reset");
                        alert('Followup email sent successfully')
                    } else {
                        //validation errors

                    }
                },
                error: function (response) {
                    resetValidationErrors($('#followUpEmailForm'))
                    handleValidationErrors($('#followUpEmailForm'), response.responseJSON.errors)
                }
            });
        });

        $(document).on('click','.follow_up', function() {
            $('.order_modal_title').html('Send Follow Up Email')
            let response = `<form id="followUpEmailForm">
            <div class="modal-body">
            <div class="row">
            <div class="col-lg-12">
            <div class="form-group" >
            <label class="form-label">Followup Email Content<span class="text-danger">*</span></label>
            <div class="form-control-wrap">
            <textarea class="summernote form-control" required="" name="email_content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem similique earum necessitatibus nesciunt! Quia id expedita asperiores voluptatem odit quis fugit sapiente assumenda sunt voluptatibus atque facere autem, omnis explicabo.</textarea>
            <span class="error"></span>
            </div>
            <input type="hidden" name='order_id' value="${$(this).data('id')}">
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Send Email</button>
            </div>
            </div>
            </div>
            </form>`;

            $('.modal-body').html(response);
            $('#OrderModal').modal('toggle');
        });

        $(document).on('click','.manual_discount', function() {
            $('.order_modal_title').html('Order Discount')
            let response = `
            <form class="form-group" action="" method="post" id="applyDiscountForm">
            <input type="hidden" name="order_id" value="${$(this).data('id')}"><br>
            <input type="hidden" name="grand_total" id="grand_total" value="${$(this).data('price-without-addon')}">
            <input type="hidden" name="price_without_addon" id="price_without_addon" value="${$(this).data('price-without-addon')}">
            <label class="label-success text-danger">Discount value will be applied on service cost</label><br>
            <label class="label label-success">Apply Discount to Order - ${$(this).data('order-no')}</label><br>
            <label class="label label-success">Actual Price - ${$(this).data('price')}</label>
            <label class="label label-success">Service Cost - ${$(this).data('price-without-addon')}</label>
            <label class="label label-success">Addon Price - ${$(this).data('addon-price')}</label><br>
            <div class="row">
            <div class="col-md-12">
            <label class="label-success">Discount in %</label>
            <input type="number" name="discount_percentage" placeholder="Apply discount in percentage" class="form-control discount_percentage" id="discount_percentage" max="100">
            <label class="final_price"></label>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
            <label class="label-success mt-2">Discount Amount</label>
            <input type="text" name="discount_amount" id="discount_amount" placeholder="Apply discount in amount" class="form-control">
            <label class="final_disc_price"></label><br>
            <label class="final_disc_percent"></label>
            </div>
            </div>
            <button type="submit" class="btn btn-sm btn-primary mt-2">Apply</button>
            </form>`;
            $('.modal-body').html(response);
            $('#OrderModal').modal('toggle');
        });

        $(document).on('keyup','#discount_percentage', function(e) {
            var discount_amount = (parseInt($('#grand_total').val()) / 100) * parseInt($(this).val());
            var new_amount = parseFloat($('#grand_total').val()) - parseFloat(discount_amount); 
            $('.final_price').text("New Price is: "+new_amount)
        });

        $(document).on('keyup','#discount_amount', function(e) {
            var diff = (parseInt($(this).val()) - parseInt($('#grand_total').val()))
            var discount_percentage = (diff / (parseInt($('#grand_total').val())) * 100);
            discount_percentage = (discount_percentage < 0) ? discount_percentage * -1 : discount_percentage;
            $('.final_disc_price').text("New Price is: "+parseInt($(this).val()))
            $('.final_disc_percent').text("Increment: "+discount_percentage+" %")
        });

        $(document).on('submit','#applyDiscountForm', function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('orders.discount') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (!data.errors) {
                        toastr.success(data.message);
                        $('#OrderModal').modal('hide');
                        $('#applyDiscountForm').trigger("reset");
                        location.reload();
                    } else {
                        //validation errors

                    }
                },
                error: function (response) {
                    resetValidationErrors($('#applyDiscountForm'))
                    handleValidationErrors($('#applyDiscountForm'), response.responseJSON.errors)
                }
            });
        });

    })


</script>
@endpush