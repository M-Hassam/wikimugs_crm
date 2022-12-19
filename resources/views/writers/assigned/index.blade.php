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
                                    <p>Under this section you will find the list of all assigned orders</p>
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
                                        <th>Order ID</th>
                                        <th>Pages</th>
                                        <th>Type Of Work</th>
                                        <th>Subject</th>
                                        <th>Topic</th>
                                        <th>Deadline</th>
                                        <th>Remaining TIme</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr @if($model->is_new==0) class="text-primary" @endif>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model->order_no ?? "---" }}</td>
                                        <td>{{ $model->price_plan_no_of_page_id ?? "---" }}</td>
                                        <td>{{ $model->type_of_work->name ?? "---" }}</td>
                                        <td>{{ $model->subjects->name ?? "---" }}</td>
                                        <td>{{ $model->topic ?? "---" }}</td>
                                        <td>{{ isset($model->writer_deadline) ? formattedDate($model->writer_deadline) : "---" }}</td>
                                        <td>
                                            @php
                                            $devlivery_date = date('Y-m-d h:i:s', strtotime($model->writer_deadline));
                                            @endphp
                                            <span style="color:red" class="counter" data-countdowndate="{{ $devlivery_date ?? "---" }}"></span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a class="ml-1" href="{{ route('writers.assigned.edit',['assigned'=>$model->id]) }}" title="Update" data-toggle="tooltip">
                                                    <em class="icon ni ni-check-circle"></em>
                                                </a>
                                                <a href="javascript:;" class="view_order ml-2" data-id="{{ $model->id }}" title="Preview" data-toggle="tooltip">
                                                    <em class="icon ni ni-eye"></em>
                                                </a>
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

@include('modals.orders.modal')

@push('scripts')
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
    $(document).on('click','.view_order', function() {
        let order_id = $(this).data('id');
        showWriterOrder(order_id);
    });
});
</script>
@endpush