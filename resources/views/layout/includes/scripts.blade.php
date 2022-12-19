<script src="{{ asset('template/src/assets/js/bundle.js?ver=2.4.0') }}"></script>
<script src="{{ asset('template/src/assets/js/scripts.js?ver=2.4.0') }}"></script>
<script src="{{ asset('template/src/assets/js/charts/gd-default.js?ver=2.4.0') }}"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function notifications(){
        $.post("{{ route('customers.notification') }}", 
            function(data){ 
                console.log("data ",data)
                if(data.status ==1){
                    if(data.data.leads > 0){
                        $(".new_lead").text(data.data.leads);
                        $('#btn_press').click();
                    }
                    if(data.data.payment_awaiting_orders > 0){
                        $(".payment_awaiting_orders").text(data.data.payment_awaiting_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.pending_orders > 0){
                        $(".pending_orders").text(data.data.pending_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.assigned_orders > 0){
                        $(".assigned_orders").text(data.data.assigned_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.writer_delivery_orders > 0){
                        $(".writer_delivery_orders").text(data.data.writer_delivery_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.delivered_orders > 0){
                        $(".delivered_orders").text(data.data.delivered_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.modified_orders > 0){
                        $(".modified_orders").text(data.data.modified_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.completed_orders > 0){
                        $(".completed_orders").text(data.data.completed_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.canceled_orders > 0){
                        $(".canceled_orders").text(data.data.canceled_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.writer_assigned_orders > 0){
                        $(".writer_assigned_orders").text(data.data.writer_assigned_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.writer_modification_orders > 0){
                        $(".writer_modification_orders").text(data.data.writer_modification_orders);
                        $('#btn_press').click();
                    }
                    if(data.data.payment_awaiting_orders > 0 || data.data.pending_orders > 0|| data.data.assigned_orders > 0|| data.data.writer_delivery_orders > 0|| data.data.delivered_orders > 0|| data.data.modified_orders > 0|| data.data.completed_orders > 0|| data.data.canceled_orders > 0){
                        $(".total_orders").text(data.data.payment_awaiting_orders+data.data.pending_orders+data.data.assigned_orders+data.data.writer_delivery_orders+data.data.delivered_orders+data.data.modified_orders+data.data.completed_orders+data.data.canceled_orders);
                        $('#btn_press').click();
                    }
                }
            });
    }

    setInterval(notifications, 5000);
</script>

<script>
    function play() {
        var audio = new Audio(
            "{{ asset('template/src/audio/beep.mp3') }}");
        audio.play();
    }
</script>