<script type="text/javascript">

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
    
    function handleValidationErrors(element, error) {
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
    
    function showOrder(order_id)
    {
        $.ajax({
            type: "GET",
            url: "{{route('orders.view_order')}}",
            data: {
                'id':order_id
            },
            success: function(response){
                console.log(response.order.client_guidlines)
                $('.order_modal_title').html('Order Information')
                let order_response = `<table class='table table-striped'>
                <tbody>
                <tr>
                <td>Order No: ${response.order.order_no}</td>
                <td>Order Date: ${response.order.created_at}</td>
                </tr>
                <tr>
                <td>Domain: ${response.order.domain.name}</td>
                <td>Customer ID: ${response.order.customer_id}</td>
                </tr>
                <tr>
                <td>Customer: ${response.order.customer.first_name}</td>
                <td>Email: ${response.order.customer.email}</td>
                </tr>
                <tr>
                <td>Topic: ${response.order.topic}</td>
                <td>Instructions: ${response.order.instructions}</td>
                </tr>
                <tr>
                <td>Type of Work: ${response.order.type_of_work.name}</td>
                <td>Delivery Within: ${response.order.urgency.name}</td>
                </tr>
                <tr>
                <td>Level: ${response.order.level.name}</td>
                <td>No Of Pages: ${response.order.price_plan_no_of_page_id}</td>
                </tr>
                <tr>
                <td>Subject: ${response.order.subjects.name}</td>
                <td>Line Spacing: ${response.line_spacing}</td>
                </tr>
                <tr>
                <td>References: ${response.order.reference}</td>
                <td>Font Style: ${response.order.font_style}</td>
                </tr>
                <tr>
                <td>Citation style: ${response.order.style.name}</td>
                <td>Addon Cost: ${response.order.domain.currency_code}${response.order.addons_amount}</td>
                </tr>
                <tr>
                <td>Service Cost: ${response.order.domain.currency_code}${response.order.discount_amount}</td>
                <td>Total Price: ${response.order.domain.currency_code}${response.order.grand_total_amount}</td>
                </tr>`
                let order_addons = ``;
                for(const addon of response.order.addons)
                    order_addons +=  `
                ${addon.addon.name} &nbsp;&nbsp ${response.order.domain.currency_code}${addon.addon.amount}<br>`;
                order_response += `
                <tr> <td> Addons: </td> <td> `+
                order_addons
                +`</td>
                </tr>

                <tr>
                <td>Files & Comments:</td>
                <td>
                <form action="{{ route('orders.comment') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name='order_id' value="${order_id}">
                <textarea type="text" class="form-control" name="comment"></textarea> <br>
                <input type="file" class="form-control" name="attachments[]" multiple>
                <button type="submit" class="btn btn-sm btn-primary mt-2">Save</button>
                </form>
                </td>
                </tr>

                </tbody>
                </table>`;

                let client_guidlines = ``;
                for(const file of response.order.client_guidlines)
                    client_guidlines +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Client Guidline</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                client_guidlines
                +`</tbody>
                </table>`;

                let writing_deptartments = ``;
                for(const file of response.order.writing_deptartments)
                    writing_deptartments +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Writing Deptartment</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                writing_deptartments
                +`</tbody>
                </table>`;

                let writer_deliveries = ``;
                for(const file of response.order.writer_deliveries)
                    writer_deliveries +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Writer Delivery</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                writer_deliveries
                +`</tbody>
                </table>`;

                let revision_writing_depts = ``;
                for(const file of response.order.revision_writing_depts)
                    revision_writing_depts +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Revision By Writing Dept</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                revision_writing_depts
                +`</tbody>
                </table>`;

                let revision_deliveries = ``;
                for(const file of response.order.revision_deliveries)
                    revision_deliveries +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Revision Delivery</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                revision_deliveries
                +`</tbody>
                </table>`;

                let revision_clients = ``;
                for(const file of response.order.revision_clients)
                    revision_clients +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Revision By Client</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                revision_clients
                +`</tbody>
                </table>`;

                let final_deliveries = ``;
                for(const file of response.order.final_deliveries)
                    final_deliveries +=  `<tr>
                <td>${file.file}</td>
                <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
                <td>${file.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Final Delivery</th>
                <th>Download</th>
                <th>Datetime</th>
                </tr>
                </thead>
                <tbody>`+
                final_deliveries
                +`</tbody>
                </table>`;

                let order_comments = ``;
                for(const item of response.order_comments)
                    order_comments +=  `<tr>
                <td>${item.user.name}</td>
                <td>${item.comment}</td>
                <td>${item.created_at}</td>
                </tr>`;
                order_response += `<table class='table'>
                <thead>
                <tr>
                <th>Added By</th>
                <th>Comments</th>
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

function showWriterOrder(order_id)
{
    $.ajax({
        type: "GET",
        url: "{{route('orders.view_order')}}",
        data: {
            'id':order_id
        },
        success: function(response){
            console.log(response.order.client_guidlines)
            $('.order_modal_title').html('Order Information')
            let order_response = `<table class='table table-striped'>
            <tbody>
            <tr>
            <td>Order No: ${response.order.order_no}</td>
            <td>Citation style: ${response.order.style.name}</td>
            </tr>
            </tr>
            <tr>
            <td>Topic: ${response.order.topic}</td>
            <td>Instructions: ${response.order.instructions}</td>
            </tr>
            <tr>
            <td>Type of Work: ${response.order.type_of_work.name}</td>
            <td>Delivery Within: ${response.order.urgency.name}</td>
            </tr>
            <tr>
            <td>Level: ${response.order.level.name}</td>
            <td>No Of Pages: ${response.order.price_plan_no_of_page_id}</td>
            </tr>
            <tr>
            <td>Subject: ${response.order.subjects.name}</td>
            <td>Line Spacing: ${response.line_spacing}</td>
            </tr>
            <tr>
            <td>References: ${response.order.reference}</td>
            <td>Font Style: ${response.order.font_style}</td>
            </tr>
            </tbody>
            </table>`;

            let order_guidelines = ``;
            for(const file of response.order.order_guidelines)
                order_guidelines +=  `<tr>
            <td>${file.file}</td>
            <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
            <td>${file.created_at}</td>
            </tr>`;
            order_response += `<table class='table'>
            <thead>
            <tr>
            <th>Order Guideline</th>
            <th>Download</th>
            <th>Datetime</th>
            </tr>
            </thead>
            <tbody>`+
            order_guidelines
            +`</tbody>
            </table>`;

            let writer_deliveries = ``;
            for(const file of response.order.writer_deliveries)
                writer_deliveries +=  `<tr>
            <td>${file.file}</td>
            <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
            <td>${file.created_at}</td>
            </tr>`;
            order_response += `<table class='table'>
            <thead>
            <tr>
            <th>Writer Delivery</th>
            <th>Download</th>
            <th>Datetime</th>
            </tr>
            </thead>
            <tbody>`+
            writer_deliveries
            +`</tbody>
            </table>`;

            let revision_deliveries = ``;
            for(const file of response.order.revision_deliveries)
                revision_deliveries +=  `<tr>
            <td>${file.file}</td>
            <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
            <td>${file.created_at}</td>
            </tr>`;
            order_response += `<table class='table'>
            <thead>
            <tr>
            <th>Revision Delivery</th>
            <th>Download</th>
            <th>Datetime</th>
            </tr>
            </thead>
            <tbody>`+
            revision_deliveries
            +`</tbody>
            </table>`;

            let revision_for_writer = ``;
            for(const file of response.order.revision_for_writer)
                revision_for_writer +=  `<tr>
            <td>${file.file}</td>
            <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
            <td>${file.created_at}</td>
            </tr>`;
            order_response += `<table class='table'>
            <thead>
            <tr>
            <th>Revision By Client</th>
            <th>Download</th>
            <th>Datetime</th>
            </tr>
            </thead>
            <tbody>`+
            revision_for_writer
            +`</tbody>
            </table>`;

            let final_deliveries = ``;
            for(const file of response.order.final_deliveries)
                final_deliveries +=  `<tr>
            <td>${file.file}</td>
            <td><a href="{{ asset('uploads/files') }}/${file.file}" target="_blank">Download</a></td>
            <td>${file.created_at}</td>
            </tr>`;
            order_response += `<table class='table'>
            <thead>
            <tr>
            <th>Final Delivery</th>
            <th>Download</th>
            <th>Datetime</th>
            </tr>
            </thead>
            <tbody>`+
            final_deliveries
            +`</tbody>
            </table>`;

            let order_comments = ``;
            for(const item of response.order_comments)
                order_comments +=  `<tr>
            <td>${item.user.name}</td>
            <td>${item.comment}</td>
            <td>${item.created_at}</td>
            </tr>`;
            order_response += `<table class='table'>
            <thead>
            <tr>
            <th>Added By</th>
            <th>Comments</th>
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

function sendOrder(order_id)
{
    $.ajax({
        type: "GET",
        url: "{{route('orders.view_order')}}",
        data: {
            'id':order_id
        },
        success: function(response){
            $('.order_modal_title').html('Send Order To Customer')
            let order_response = `<table class='table table-striped'>
            <tbody>
            <tr>
            <td>Order NO: ${response.order.order_no}</td>
            <td></td>
            </tr>
            <tr>
            <td>
            <form action="{{ route('orders.send') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name='order_id' value="${order_id}">
            
            <div class="row mt-2">
            <div class="col-lg-12">
            <div class="form-group" >
            <div class="form-control-wrap">
            <fieldset id="order_attachments">
            <div class="fieldwrapper row" id="field1">
            <div class="col-6">
            Attach files<input type="file" name='attachments[]' id="file1" class="form-control">
            </div>
            <div class="col-6">
            <i class="icon ni ni-trash-empty-fill removeFile" style="color: red"></i>
            <input type="button" value="Add More" class="add add_more_btn btn btn-secondary btn-sm" id="add_file" />
            </div>
            </div>
            </fieldset>
            </div>
            </div>
            </div>
            </div>

            <button type="submit" class="btn btn-sm btn-primary mt-2">Send to Customer</button>
            </form>
            </td>
            </tr>
            </tbody>
            </table>`;
            $('.modal-body').html(order_response);
            $('#OrderModal').modal('toggle');
        }
    });
}

$(document).on('click','.removeFile',function(){
    document.getElementById("file1").value=null; 
});

$(document).on('click','#add_file',function(){
    var lastField = $("#order_attachments div:last");
    var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
    var fieldWrapper = $("<div class=\"fieldwrapper row mt-2\" id=\"field" + intId + "\"/>");
    fieldWrapper.data("idx", intId);
    var fName = $("<div class=\"col-6\"> <input type=\"file\" name=\"attachments[]\" class=\" form-control\" /> </div>");
    var removeButton = $("<div class=\"col-6\"> <i class=\"icon ni ni-trash-empty-fill remove\" style=\"color: red\"></i> </div> </div>");
    removeButton.click(function() {
        $(this).parent().remove();
    });
    fieldWrapper.append(fName);
    fieldWrapper.append(removeButton);
    $("#order_attachments").append(fieldWrapper);
});
</script>