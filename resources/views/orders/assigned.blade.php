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
                                <h3 class="nk-block-title page-title">Assigned Orders</h3>
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
                                                    {{-- <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter</span>
                                                    </div> --}}
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <form action="{{ route('orders.pending') }}" method="get">
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
                                        <th>Cs ID</th>
                                        <th>Cs Name</th>
                                        <th>Actual Time</th>
                                        <th>Remaining Time</th>
                                        <th>Assigned To</th>
                                        <th>Writer Deadline</th>
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
                                        <td>{{ isset($model['urgency']) ? $model['urgency']->name : "---" }}</td>
                                        <td>
                                            @php
                                            $order_date = $model->created_at->toDateTimeString();
                                            $devlivery_date =  date('Y-m-d h:i:s', strtotime($order_date. ' + '.$model['urgency']->name));

                                            $endTime = \Carbon\Carbon::parse($devlivery_date);
                                            $startTime = \Carbon\Carbon::parse($order_date);
                                            $timeleft = $startTime->diffForHumans($endTime);
                                            @endphp
                                            @if(isset($model['urgency']))
                                            <span style="color:black" class="counter" data-countdowndate="{{ $devlivery_date ?? "---" }}"></span>
                                            @else
                                            {{ isset($model['urgency']) ? remainingTime($model) : "---" }}
                                            @endif
                                        </td>
                                        <td>{{ isset($model['writer']) ? $model['writer']->name : "---" }}</td>
                                        <td>{{ isset($model->writer_deadline) ? $model->writer_deadline : "---" }}</td>
                                        <td>{{ date('d-m-Y h:i:s', strtotime($model->created_at)) ?? "---" }}</td>
                                        <td>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right" style="">
                                                    <ul class="link-list-opt no-bdr">
                                                        @can('permission',62)
                                                        <li>
                                                            <a href="{{ route('orders.remove_writer',$model->id) }}" data-id={{ $model->id }}>
                                                                <em class="icon ni ni-trash"></em>
                                                                <span>Remove Writer</span>
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
                                                            <a href="{{ $model['domain']->url.'userarea/crm-login/'.$model['customer']->email }}" target="_blank" class="" data-customer-id="{{ $model->id }}" title="User area" data-toggle="tooltip">
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
    var counters = document.getElementsByClassName('counter');
    var intervals = new Array();

    for (var i = 0, lng = counters.length; i < lng; i++) {
      (function(i) {
        var x = i;

        // Update the count down every 1 second
        intervals[i] = setInterval(function() {
          var counterElement = counters[x];
          var counterDate = counterElement.dataset.countdowndate;

          // Set the date we're counting down to
          var countDownDate = new Date(counterDate);

          // Get current date and time
          var now = new Date().getTime();

          // Find the distance between now an the count down date
          var distance = countDownDate - now;

          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Display the result in the element with id='demo'
          counterElement.innerHTML = days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';

          // If the count down is finished, write some text
          if (distance < 0) {
            clearInterval(intervals[x]);
            counterElement.style.color = 'red';
            counterElement.style.fontWeight = '900';
            counterElement.innerHTML = '---';
        }
    }, 1000);
    })(i);
}


$(document).ready(function(){
    DomainSelect();

    $(document).on('click','.view_order', function() {
        let order_id = $(this).data('id');
        showOrder(order_id);
    });
})


</script>
@endpush