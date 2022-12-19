@extends('layout.app')


@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview">
                            <div class="nk-block nk-block-lg">
                            <div class="nk-block-head nk-block-head-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-between g-3">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Order</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>You have total <span class="count"></span> orders.</p>
                                                <div class="form-inline">
                                                    <label class="form-label" style="padding-right: 10px">Domain:  </label>
                                                    <div class="form-control-wrap" style="width: 150px">
                                                        <select id="domain_id" name="domain_id" class="form-select form-control form-control-lg DomainSelect" data-search="on">
                                                        </select>
                                                        <span class="error"></span>
                                                    </div>
                                                    {{-- <label class="form-label" style="padding-right: 10px;padding-left: 10px">Status:  </label>
                                                    <div class="form-control-wrap" style="width: 150px">
                                                        <select id="status_id" name="status_id" class="form-select form-control form-control-lg OrderStatus" data-search="on">
                                                        </select>
                                                        <span class="error"></span>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content">
                                            <ul class="nk-block-tools g-3">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="{{route('orders.create')}}"><span>Add New</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <table class="datatable nowrap nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false">
                                        <thead>
                                            <th>#</th>
                                            <th>Domain</th>
                                            <th>Lead ID</th>
                                            <th>Total</th>
                                            <th>Discount Value</th>
                                            <th>Discount Amount</th>
                                            <th>Grand Total</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Order Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade zoom" tabindex="-1" id="OrderModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><label class="order_modal_title"></label></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer bg-light">
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<link rel="stylesheet" href="{{ asset('template/src/assets/css/editors/summernote.css') }}">
<script src="{{ asset('template/src/assets/js/libs/editors/summernote.js') }}"></script>
<script src="{{ asset('template/src/assets/js/editors.js') }}"></script>
<script type="text/javascript">

    function getOrders() 
    {
        console.log('All the orders');
        $('.datatable').DataTable().destroy();
        $.fn.dataTable.ext.errMode = 'none';
        var url = "{{url('orders/get')}}";
        console.log('url',url);
        table = $('.datatable').DataTable({
                language: {
                    "emptyTable": "No records available"
                },
                processing: true,
                serverSide: true,
                // stateSave: true,
                ajax: {
                    // url: url+queryParams,
                    url: url,
                    type: "POST",
                    data:{
                        'domain_id':$('#domain_id').val(),
                        'status_id':<?php echo json_encode($order_selected_status); ?>
                    }
                },
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return `<input type="checkbox" >`;
                        },
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'domain.name',
                        name: 'domain.name',
                    },
                    {
                        data: 'lead_id',
                        name: 'lead_id',
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                    },
                    {
                        data: 'manual_discount_amount',
                        name: 'manual_discount_amount',
                    },
                    {
                        data: 'discount_amount',
                        name: 'discount_amount',
                    },
                    {
                        data: 'grand_total_amount',
                        name: 'grand_total_amount',
                    },
                    {
                        data: 'status.title',
                        name: 'status.title',
                    },
                    {
                        name: 'created_at',
                        data: 'created_at',
                    },
                    {
                        data: 'status',
                        render: function (data, type, row) {
                            
                            let order_statuses_response = '';

                            console.log('row',row);

                            for(const item of row.order_statuses)
                            {
                                console.log(item.id+' '+row.status_id);
                                if(item.id == row.status_id)
                                   order_statuses_response += `<option selected value="${item.id}" >${item.title}</option>`;
                                else
                                   order_statuses_response += `<option value="${item.id}" >${item.title}</option>`;
                            }

                            return `<select data-id="${row.id}" name="order_status_id" class="form-control order_status">`+order_statuses_response+`</select>`;
                        }
                    },
                    {
                        data: 'action',
                        render: function (data, type, row) {
                            return `<div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-right" style="">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="javascript:;" data-id="${row.id}" class="assign_to_writer"><em class="icon ni ni-user-add"></em><span>Assign to Writer</span></a>
                                                </li>
                                                <li><a href="javascript:;" data-id="${row.id}" class="update_payment"><em class="icon ni ni-amazon-pay"></em><span>Update Payment</span></a>
                                                </li>
                                                <li><a href="javascript:;" data-id="${row.id}" class="follow_up"><em class="icon ni ni-mail"></em><span>Follow Up</span></a>
                                                </li>
                                                <li><a href="{{ url('orders').'/' }}${row.id}/edit"><em class="icon ni ni-pen2"></em><span>Edit</span></a>
                                                </li>
                                                <li><a href="{{ url('orders').'/delete/' }}${row.id}"><em class="icon ni ni-trash-fill"></em><span>Delete</span></a>
                                                </li>
                                                <li><a href="javascript:;" class="view_order" data-id=${row.id}><em class="icon ni ni-eye"></em><span>Preview</span></a>
                                                </li>
                                                <li><a href="{{ url('orders').'/' }}${row.id}/logs"><em class="icon ni ni-file-docs"></em><span>Logs</span></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>`;
                        }
                    },
                ],
                select: true,
                order: [
                [2, "desc"]
                ],
                searching: false,
                iDisplayLength: 10,
        });
            
        table.on('click', '.edit', function () {
            var data = table.row($(this).parents('tr')).data();
            $('#departmentId').val(data.id);
            $('#editDepartmentForm').find($('input[name="name"]')).val(data.name);
            $('#editDepartmentForm').find($('select[name="status"]')).val(data.status);
            $('#editDepartmentModal').modal('show');
        });

        table.on('click', '.delete', function () {
            var data = table.row($(this).parents('tr')).data();
            $('#departmentId').val(data.id);
            $('#deleteDepartmentModal').modal('show');
        });
    }

    function DomainSelect() 
    {
        $('.DomainSelect').select2({
            width: '100%',
            minimumInputLength: 0,
            dataType: 'json',
            placeholder: 'Select',
            ajax: {
                url: function () {
                    return "{{route('domains.autocomplete')}}";
                },
                processResults: function (data, page) {
                    return {
                        results:  $.map(data, function (item) {
                           return {
                             text: item.name,
                             id: item.id
                           }
                        })
                    };
                }
            }
        });
    }

    function WriterSelect() 
    {
        $('.WriterSelect').select2({
            width: '100%',
            minimumInputLength: 0,
            dataType: 'json',
            placeholder: 'Select',
            ajax: {
                url: function () {
                    return "{{route('writers.autocomplete')}}";
                },
                processResults: function (data, page) {
                    return {
                        results:  $.map(data, function (item) {
                           return {
                             text: item.name,
                             id: item.id
                           }
                        })
                    };
                }
            }
        });
    }

    function StatusSelect() 
    {
        $('.OrderStatus').select2({
            width: '100%',
            minimumInputLength: 0,
            dataType: 'json',
            placeholder: 'Select',
            ajax: {
                url: function () {
                    return "{{route('orders.statuses')}}";
                },
                processResults: function (data, page) {
                    return {
                        results:  $.map(data, function (item) {
                           return {
                             text: item.title,
                             id: item.id
                           }
                        })
                    };
                }
            }
        });
    }

    function showOrder(order_id)
    {
        $.ajax({
            type: "GET",
            url: "{{route('orders.view_order')}}",
            data: {
                'id':order_id
            },
            success: function(response){
                $('.order_modal_title').html('Order Information')
               let order_response = `<table class='table'>
                                        <tbody>
                                          <tr>
                                            <td>Domain: </td>
                                            <td>Lead: </td>
                                          </tr>
                                          <tr>
                                            <td>Status: ${response.order.status.title}</td>
                                            <td>Customer: ${response.order.customer.first_name}</td>
                                          </tr>
                                          <tr>
                                            <td>Level: ${response.order.level.name}</td>
                                            <td>Type of Work: ${response.order.type_of_work.name}</td>
                                          </tr>
                                          <tr>
                                            <td>Urgency: ${response.order.urgency.name}</td>
                                            <td>Grand Total Amount: ${response.order.grand_total_amount}</td>
                                          </tr>
                                        </tbody>
                                    </table>`;

                let order_comments = ``;
                console.log('response.order_comments',response.order_comments)
                for(const item of response.order_comments)
                   order_comments +=  `<tr>
                                        <td>${item.comment}</td>
                                        <td>${item.comment}</td>
                                        <td>${item.comment}</td>
                                      </tr>`;

                order_response += `<table class='table'>
                                        <thead>
                                           <tr>
                                            <th>Added By</th>
                                            <th>Remarks</th>
                                            <th>Datetime</th>
                                          </tr>
                                        </thead>
                                        <tbody>`+
                                           order_comments
                                        +`</tbody>
                                      </table>`;

                $('.modal-body').html(order_response);

               $('#OrderModal').modal('toggle');
            }
       });
    }

    function statusChange(order_id,status_id)
    {
        $.ajax({
            type: "GET",
            url: "{{url('orders/status/change/')}}"+"/"+order_id,
            data:{
               'status_id':status_id
            },
            success: function(response){
               alert('Status Change Successfully')
               getOrders();
            }
       });
    }

    function handleValidationErrors(element, error) 
    {
        console.log('error',error);
        element.find($('input')).each(function(index, el) {
            var el = $(el);
            if(error[el.attr('name')]) {
                el.next('.error').html(error[el.attr('name')]);
            } else {
                el.next('.error').html('');
            }

        });

        element.find($('select')).each(function(index, el) {
            var el = $(el);

            if(error[el.attr('name')]) {
                el.next('.error').html(error[el.attr('name')]);
                el.closest('div').find('.error').html(error[el.attr('name')]);
            } else {
                el.closest('div').find('.error').html('');
            }
        });
    }

    function resetValidationErrors(element) {
        element.find($('input')).each(function(index, el) {
            var el = $(el);
            el.next('.error').html('');
        });
        element.find($('select')).each(function(index, el) {
            var el = $(el);
            el.closest('div').find('.error').html('');
        });
    }

    $(document).ready(function(){
        DomainSelect();
        StatusSelect();
        getOrders();

        $('#domain_id,#status_id').on('change',function(){
            console.log("$('#domain_id').val()",$('#domain_id').val());
            getOrders();
        });

        $(document).on('click','.view_order', function() {
            let order_id = $(this).data('id');
            console.log('order_id',order_id);
            showOrder(order_id);
        });

        $(document).on('submit','#WriterForm', function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('writers.assign_order') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (!data.errors) {
                        toastr.success(data.message);
                        $('#OrderModal').modal('hide');
                        $('#WriterForm').trigger("reset");
                        table.draw();
                        getCount();
                    } else {
                        //validation errors
                       
                    }
                },
                error: function (response) {
                    resetValidationErrors($('#WriterForm'))
                    handleValidationErrors($('#WriterForm'), response.responseJSON.errors)
                }
            });
        });


        $(document).on('click','.assign_to_writer', function() {
            $('.order_modal_title').html('Assign to Writer')
            let response = `<form id="WriterForm">
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group" >
                                                <label class="form-label">Writer <span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <select name="writer_id" class="form-select form-control form-control-lg WriterSelect" data-search="on">
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
            WriterSelect();

            $('#OrderModal').modal('toggle');
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
                        table.draw();
                        getCount();
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
                                                    <select name="payment_status" class="form-select form-control form-control-lg">
                                                    <option value='1'>Paid</option>
                                                    <option value='0'>Not Paid</option>
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
                        // table.draw();
                        // getCount();
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
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group" >
                                                <label class="form-label">Followup Email Content<span class="text-danger">*</span></label>
                                                <div class="form-control-wrap">
                                                    <textarea class="summernote" required="" rows="4" cols="80" name="email_content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem similique earum necessitatibus nesciunt! Quia id expedita asperiores voluptatem odit quis fugit sapiente assumenda sunt voluptatibus atque facere autem, omnis explicabo.</textarea>
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

        $(document).on('change','.order_status', function() {
            let status_id = $(this).val();
            let order_id = $(this).data('id');
            statusChange(order_id,status_id);
        });

    })


</script>
@endpush