@extends('layout/app')


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
                                        <div class="nk-block-head-sub"><a class="back-to" href="{{ route('orders.index') }}"><em class="icon ni ni-arrow-left"></em><span>Orders</span></a></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            @if(isset($lead_id))
                                              <form id="orderForm" action="{{route('orders.store')}}">
                                            @else
                                              <form id="orderForm" action="{{route('orders.store.customer')}}">
                                            @endif
                                                <div class="row g-4">
                                                    @if(isset($domain_id))
                                                      <input id="domain_id" name="domain_id" type="hidden" value="{{ isset($domain_id) ? $domain_id : $order->domain->id  }}">
                                                    @endif  
                                                    @if(isset($lead_id))
                                                      <input id="lead_id" name="lead_id" value="{{ isset($lead_id) ? $lead_id : $order->lead->id }}" type="hidden">
                                                    @endif
                                                    <input id="status_id" name="status_id" value="1" type="hidden">
                                                    <input id="coupon_id" name="coupon_id" value="" type="hidden">
                                                    <input id="discount_amount" name="discount_amount" type="hidden">
                                                    <input id="total_amount" name="total_amount" type="hidden">
                                                    <input id="customer_id" name="customer_id" type="hidden" value="{{ $order->customer->id ?? '' }}">
                                                    
                                                    @if(!isset($domain_id))
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Domain<span class="text-danger">*</span></label>
                                                                <div class="form-control-wrap">
                                                                  <select id="domain_id" name="domain_id" class="form-select form-control form-control-lg DomainSelect" data-search="on">
                                                                  </select>
                                                                  <span class="error"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                        </div>
                                                    @endif

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Type of work<span class="text-danger">*</span></label>
                                                            <div class="form-control-wrap">
                                                                <select id="type_of_work_id" name="price_plan_type_of_work_id" class="js-example-data-ajax form-select form-control form-control-lg pricePlanTypeOfWorksSelect" data-search="on">
                                                                </select>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Level <span class="text-danger">*</span></label>
                                                            <div class="form-control-wrap">
                                                                <select id="price_plan_level_id" name="price_plan_level_id" class="form-select form-control form-control-lg pricePlanLevelsSelect" data-search="on">
                                                                </select>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Urgencies <span class="text-danger">*</span></label>
                                                            <div class="form-control-wrap">
                                                                <select id="price_plan_urgency_id" name="price_plan_urgency_id" class="form-select form-control form-control-lg pricePlanUrgenciesSelect" data-search="on">
                                                                </select>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label">No of pages <span class="text-danger">*</span></label>
                                                            <div class="form-control-wrap">
                                                                <select id="price_plan_no_of_page_id" name="price_plan_no_of_page_id" class="form-select form-control form-control-lg pricePlanNoOfPagesSelect" data-search="on">
                                                                </select>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="col-lg-6" style="background-color: #ebeef2!important">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-radio custom-control-sm">
                                                                <input checked type="radio" id="single" name="spaced" class="custom-control-input spaced" value="1">
                                                                <label class="custom-control-label font-weight-bold" for="single">Single Spaced</label>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6" style="background-color: #ebeef2!important">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-radio custom-control-sm" >
                                                                <input type="radio" id="multiple" name="spaced" class="custom-control-input spaced" value="0">
                                                                <label class="custom-control-label font-weight-bold" for="multiple">Double Spaced</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    @if(!isset($lead_id))
                                                        @if(!isset($order->customer))
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="topic">Customer Name</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="name" name="name" placeholder="name" value="{{ $order->customer->first_name ?? '' }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="topic">Customer Email</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="email" name="email" placeholder="email" value="{{ $order->customer->email ?? '' }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="topic">Customer Phone</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="phone" value="{{ $order->customer->phone ?? '' }}">
                                                                        <span class="error"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">

                                                            </div>
                                                        @endif
                                                    @endif
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="topic">Topic</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="topic" name="topic" placeholder="Topic" value="{{ $order->topic ?? '' }}">
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">

                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Subject</label>
                                                            <div class="form-control-wrap">
                                                                <select id="price_plan_subject_id" name="price_plan_subject_id" class="form-select form-control form-control-lg pricePlanSubjectsSelect" data-search="on">
                                                                </select>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Style <span class="text-danger">*</span></label>
                                                            <div class="form-control-wrap">
                                                                <select id="price_plan_style_id" name="price_plan_style_id" class="form-select form-control form-control-lg pricePlanStyleSelect" data-search="on">
                                                                </select>
                                                                <span class="error"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="instructions">Instructions </label>
                                                            <div class="form-control-wrap">
                                                                <textarea class="form-control form-control-sm" id="instructions" name="instructions" placeholder="Write instructions for the writer" required="">{{ $order->instructions ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-sm-12">
                                                        <label class="form-label">Attachments</label>
                                                        <div class="upload-zone">
                                                            <div class="dz-message" data-dz-message>
                                                                <span class="dz-message-text">Drag and drop file</span>
                                                                <span class="dz-message-or">or</span>
                                                                <a>Attach file</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @foreach ($addOns as $addOn)
                                                    <div class="col-lg-6" style="background-color: #ebeef2!important">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox custom-control-sm">
                                                                <input name="addOns[]" type="checkbox" class="custom-control-input addOns addOn{{$addOn->id}}" id="{{$addOn->name}}" value="{{$addOn->id}}">
                                                                <label class="custom-control-label font-weight-bold" for="{{$addOn->name}}">{{$addOn->name}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    
                                                    {{-- <div class="col-lg-6" style="background-color: #ebeef2!important">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox custom-control-sm">
                                                                <input type="checkbox" class="custom-control-input " id="summary">
                                                                <label class="custom-control-label font-weight-bold" for="summary">1-Page Summary
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .components-preview -->

                                    <div class="col-md-4">
                                    {{-- <div class="card card-bordered">
                                        <div class="card-inner">
                                            <h6 class="title">Cart</h6>
                                        </div>

                                        <div class="orders-add-ons">
                                            <li>Plagarish <span>123</span> </li>
                                        </div>
                                                        
                                        <div class="" style="background-color: #ebeef2!important">
                                            <div class="d-flex justify-content-between p-2">
                                                <h6 class="text-soft m-0">Total Price</h6>
                                                <h6 class="text-soft float-right">50$</h6>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="card h-40">
                                        <div class="card-inner">
                                            <div class="card-title-group mb-2">
                                                <div class="card-title">
                                                    <h6 class="title">Cart</h6>
                                                </div>
                                            </div>
                                            <ul class="nk-store-statistics orders-basic_details">
                                                <div class="empty-container d-flex justify-content-center">
                                                    <em style="font-size: 100px; padding: 100px;" class="icon ni ni-cart"></em>
                                                </div>
                                            </ul>
                                            <ul class="nk-store-statistics orders-add-ons-container">
                                            </ul>
                                        </div><!-- .card-inner -->

                                        <div style="background-color: #ebeef2!important">
                                            <div class="d-flex justify-content-between p-2">
                                                <h6 class="text-soft m-0">Discount Types</h6>
                                                <select class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="amount">Amount</option>
                                                    <option value="percentage">Percentage</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="background-color: #ebeef2!important">
                                            <div class="d-flex justify-content-between p-2">
                                                <h6 class="text-soft m-0">Discount Value</h6>
                                                <input type="number" class="form-control text-soft float-right discount_value" name="manual_discount_amount" value="0">
                                            </div>
                                        </div>
                                        <div style="background-color: #ebeef2!important">
                                            <div class="d-flex justify-content-between p-2">
                                                <h6 class="text-soft m-0">Total Price</h6>
                                                <input type="number" class="form-control text-soft float-right total-price" name="">
                                            </div>
                                        </div>
                                        <div style="background-color: #ebeef2!important">
                                            <div class="d-flex justify-content-between p-2">
                                                <h6 class="text-soft m-0">Apply Coupon</h6> &nbsp;&nbsp;
                                                <input type="text" class="form-control" id="discount_serial_no" name="discount_serial_no" value="{{ $order->coupon->code ?? '' }}">
                                                <button class="btn btn-primary ml-1">Apply</button>
                                            </div>
                                        </div>
                                        <div style="background-color: #ebeef2!important">
                                            <div class="d-flex justify-content-between p-2">
                                                <h6 class="text-soft m-0">Grand Total</h6>&nbsp;&nbsp;
                                                <input type="number" id="grand_total_amount" name="grand_total_amount" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-inner">
                                            <div>
                                                <a id="order-btn" class="btn btn-dim btn-success d-block disabled">{{ isset($order->id) ? 'Update' : 'Order Now' }}</a>
                                            </div>
                                        </div>
                                    </div><!-- .components-preview -->
                                </div>
                            </form>

                        </div> <!-- nk-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">

    $(function () {

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
        
        function pricePlanLevelsSelect(domain_id = 0) 
        {
            console.log('domain_id',domain_id);
            let data = {};
            if(domain_id)
                data['domain_id'] = domain_id;
            else
                data['domain_id'] = "{{ isset($domain_id) ? $domain_id : $order->domain->id ?? 0  }}";

            console.log('data',data);

            $('.pricePlanLevelsSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_levels.order.autocomplete')}}";
                    },
                    data:data,
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
        
        function pricePlanUrgenciesSelect(domain_id = 0) 
        {
            console.log('domain_id',domain_id);
            let data = {};
            if(domain_id)
                data['domain_id'] = domain_id;
            else
                data['domain_id'] = "{{ isset($domain_id) ? $domain_id : $order->domain->id ?? 0  }}";

            console.log('data',data);

            $('.pricePlanUrgenciesSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_urgencies.order.autocomplete')}}";
                    },
                    data:data,
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

        function pricePlanStyleSelect() 
        {
            $('.pricePlanStyleSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_styles.autocomplete')}}";
                    },
                    data:{
                        'domain_id':"{{ isset($domain_id) ? $domain_id : $order->domain->id ?? "1" }}"
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
        
        function pricePlanTypeOfWorksSelect(domain_id = 0) 
        {
            console.log('domain_id',domain_id);
            let data = {};
            if(domain_id)
                data['domain_id'] = domain_id;
            else
                data['domain_id'] = "{{ isset($domain_id) ? $domain_id : $order->domain->id ?? 0  }}";

            console.log('data',data);

            $('.pricePlanTypeOfWorksSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_type_of_works.order.autocomplete')}}";
                    },
                    data:data,
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
        
        function pricePlanNoOfPagesSelect(single_spaced = false) 
        {
            $('.pricePlanNoOfPagesSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_no_of_pages.autocomplete')}}";
                    },
                    data: function (params) {
                        var query = {
                            q: params.term,
                            single_spaced: single_spaced,
                        }
                        return query;
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
        
        function pricePlanSubjectsSelect() 
        {
            $('.pricePlanSubjectsSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_subjects.autocomplete')}}";
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

        function calculatePrice() 
        {
            $.ajax({
                data: $('#orderForm').serialize(),
                url: "{{ route('orders.calculate') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (!data.errors) {
                        $('.empty-container').html('');
                        $('.orders-add-ons-container').html('');
                        $('.total-price').val(data.total_amount);
                        $('#total_amount').val(data.total_amount);
                        $('#discount_id').val(data.discount_id);
                        $('#coupon_id').val(data.coupon_id);
                        $('#discount_amount').val(data.discount_amount);
                        $('#grand_total_amount').val(data.grand_total_amount);

                        pricePlanNoOfPagesSelect(data.single_spaced);

                        data.addOns.forEach(function(item, key) {
                            $('.orders-add-ons-container').append(`
                                <li class="item" data-id="${item.id}">
                                <div class="info">
                                <div class="title">${item.name}</div>
                                <div class="count">${item.amount}</div>
                                </div>
                                <em class="icon ni ni-cross-sm remove-add-on pointer"></em>
                                </li>
                                `);
                        });
                        
                        if(data.basic_details) {
                            $('.orders-basic_details').html(`
                                <li class="item">
                                <div class="info">
                                <div class="title">${data.basic_details}</div>
                                </div>
                                </li>
                                `);
                        }
                        $('#order-btn').removeClass('disabled');
                        // toastr.success(data.message);
                    } else {
                        //validation errors
                    }
                },
                error: function (response) {
                }
            });
        }

        $('.DomainSelect').on('change', function(e) {
            e.preventDefault();
            console.log("$('#domain_id').val()",$('#domain_id').val())
            pricePlanLevelsSelect($('#domain_id').val());
            pricePlanUrgenciesSelect($('#domain_id').val()); 
            pricePlanTypeOfWorksSelect($('#domain_id').val());
        });

        $('.pricePlanTypeOfWorksSelect, .pricePlanLevelsSelect, .pricePlanNoOfPagesSelect, .pricePlanUrgenciesSelect, .addOns, .discount_value').on('change', function(e) {
            e.preventDefault();
            calculatePrice();
        });

        $('.spaced').on('change', function(e) {
            e.preventDefault();
            let single_spaced = $(this).val();
            pricePlanNoOfPagesSelect(single_spaced);
            $('.pricePlanNoOfPagesSelect').trigger("reset");
            $('.pricePlanNoOfPagesSelect').trigger("change");
        });
        
        $('body').on('click', '.remove-add-on', function(e) {
            let row = $(this).closest('.item');
            let addOnId = $(row).attr('data-id');
            $(`.addOn${addOnId}`).prop('checked', false);
            row.remove();
            calculatePrice();
            console.log('row', row);
        });

        $('body').on('change', '#discount_serial_no', function(e) {
           calculatePrice();
       });

        //order button submite form
        $('#order-btn').click(function() {

            let total_attachments = 0;
            let order = <?php echo json_encode($order->id ?? ''); ?>;
            console.log('order',order);

            // if(order =='')
            // {
            //     total_attachments = $( "input[name*='attachments']").length;
            //     console.log('total_attachments',total_attachments);

            //     if(total_attachments <= 0)
            //         alert('Please Add atleast one Attachment');
            // }

            let lead_check = "{{ isset($lead_id) }}";
             
            console.log('lead_check',lead_check);

            let url ="";

            if(lead_check)
              url = "{{ isset($order->id) ? route('orders.update',['order'=>$order->id]) : route('orders.store') }}";
            else
              url = "{{ isset($order->id) ? route('orders.update',['order'=>$order->id]) : route('orders.store.customer') }}";

            console.log('url',url);

            $.ajax({
                data: $('#orderForm').serialize(),
                url: url,
                type: "{{ isset($order->id) ? 'PUT' : 'POST' }}",
                dataType: 'json',
                success: function (data) {
                    alert("{{ isset($order->id) ? 'Order updated Successfully' : 'Order created Successfully' }}");
                    if (!data.errors) 
                        window.location.href = "{{ url('orders') }}?status=1";    
                },
                error: function (response) {
                    resetValidationErrors($('#orderForm'))
                    handleValidationErrors($('#orderForm'), response.responseJSON.errors)
                }
            })

        });
        
        DomainSelect();
        pricePlanLevelsSelect();
        pricePlanUrgenciesSelect();
        pricePlanNoOfPagesSelect();
        pricePlanTypeOfWorksSelect();
        pricePlanSubjectsSelect();
        pricePlanStyleSelect();

        //Domain
        let array = <?php echo json_encode($order->domain ?? []); ?>;
        console.log(array);
        let data = {
            id: array.id,
            text: array.name
        };

        let option = new Option(data.text, data.id, false, false);
        $('#domain_id').append(option).trigger('change');
        
        //Type of work
        array = <?php echo json_encode($order->type_of_work ?? []); ?>;
        console.log(array);
        data = {
            id: array.id,
            text: array.name
        };

        option = new Option(data.text, data.id, false, false);
        $('#type_of_work_id').append(option).trigger('change');
        
        //Level
        array = <?php echo json_encode($order->level ?? []); ?>;
        console.log(array);
        data = {
            id: array.id,
            text: array.name
        };

        option = new Option(data.text, data.id, false, false);
        $('#price_plan_level_id').append(option).trigger('change');
        
        //Urgencies
        array = <?php echo json_encode($order->urgency ?? []); ?>;
        console.log(array);
        data = {
            id: array.id,
            text: array.name
        };

        option = new Option(data.text, data.id, false, false);
        $('#price_plan_urgency_id').append(option).trigger('change');

        //No of Pages
        array = <?php echo json_encode($order->no_of_pages ?? []); ?>;
        console.log(array);
        data = {
            id: array.id,
            text: array.name
        };

        option = new Option(data.text, data.id, false, false);
        $('#price_plan_no_of_page_id').append(option).trigger('change');

        //Subject
        array = <?php echo json_encode($order->subjects ?? []); ?>;
        data = {
            id: array.id,
            text: array.name
        };

        option = new Option(data.text, data.id, false, false);
        $('#price_plan_subject_id').append(option).trigger('change');


        //Style
        array = <?php echo json_encode($order->style ?? []); ?>;
        data = {
            id: array.id,
            text: array.name
        };

        option = new Option(data.text, data.id, false, false);
        $('#price_plan_style_id').append(option).trigger('change');
        
    });

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

function resetValidationErrors(element) 
{
    element.find($('input')).each(function(index, el) {
        var el = $(el);
        el.next('.error').html('');
    });
    element.find($('select')).each(function(index, el) {
        var el = $(el);
        el.closest('div').find('.error').html('');
    });
}

var uploadedAttachmentsMap = {}
$(".upload-zone").dropzone({
    url: '{{ route('orders.storeMedia') }}',
        maxFilesize: 25, // MB
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 2
        },
        success: function (file, response) {
            console.log('response',response);
            $('form').append('<input type="hidden" name="attachments[]" value="' + response.success + '">')
            uploadedAttachmentsMap[file.name] = response.name
        },
        removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedAttachmentsMap[file.name]
            }
            $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
        },
        init: function () {
            @if(isset($order) && $order->attachments)
            var files =
            {!! json_encode($order->attachments) !!}
            for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
            }
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }
            
            return _results
        }
    });
</script>
@endpush
