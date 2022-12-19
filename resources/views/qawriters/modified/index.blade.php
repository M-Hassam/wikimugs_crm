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
                                <h3 class="nk-block-title page-title">Modified Orders</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all modified orders</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                {{-- <a href="{{ route('leads.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a> --}}
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
                                        <th>Order ID</th>
                                        <th>Price</th>
                                        <th>Pages</th>
                                        <th>Type Of Work</th>
                                        <th>Subject</th>
                                        <th>Topic</th>
                                        <th>Deadline</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model->total_amount ?? "---" }}</td>
                                        <td>{{ $model->type_of_work->name ?? "---" }}</td>
                                        <td>{{ $model->type_of_work->name ?? "---" }}</td>
                                        <td>{{ $model->email ?? "---" }}</td>
                                        <td>{{ $model->phone ?? "---" }}</td>

                                        <td>{{ $model->deadline_date ?? "---" }} {{ $model->deadline_time ?? "---" }}</td>
                                            {{-- <td>
                                                <div class="action-buttons">
                                                    <a class="ml-1" href="{{ route('writers.assigned.edit',['assigned'=>$model->id]) }}" title="Update" data-toggle="tooltip">
                                                        <em class="icon ni ni-check-circle"></em>
                                                    </a>
                                                </div>
                                            </td> --}}
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
@include('modals.leads.followup')
@include('modals.leads.followup_comments')
@include('modals.leads.preview')
@endsection

@push('scripts')
<link rel="stylesheet" href="{{ asset('template/src/assets/css/editors/summernote.css') }}">
<script src="{{ asset('template/src/assets/js/libs/editors/summernote.js') }}"></script>
<script src="{{ asset('template/src/assets/js/editors.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.summernote').summernote({
            toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['table', ['table']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
            ]
        });

        $('.datatable').dataTable( {
            "paging": false
        } );

        $(document).on('click','.followup_email',function(){
            var con = confirm('Are you sure you want to send email?');
            if(con == true){
                $('#followup_modal').modal('toggle');
                $('.lead_email').val($(this).data('lead-email'))
                $('.lead_id').val($(this).data('lead-id'))

            }
        });

        $(document).on('change','.lead_status',function(){
            let lead_id = $(this).data('lead-id');
            let status = $(this).val();

            if(this.value==3){
                $('.lead_id').val(lead_id)
                $('#followup_comments_modal').modal('toggle');

            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ route('leads.status') }}",
                    data:{'status':status,'lead_id':lead_id},
                    success:function(data){
                        if(data.status==1){
                            $(this).val(status)
                            alert('status upated successfully');
                            location.reload()
                        }
                    }
                });
            }
        });

        $(document).on('click','.add_comments',function(){
            $('.lead_id').val($(this).data('lead-id'))
            $('.comment_check').val(1)
            $('#followup_comments_modal').modal('toggle');
        });

        $(document).on('click','.preview',function(){
            var url = $(this).data('route-url');
            $.ajax({
                type: "GET",
                url: url,
                success:function(data){
                    if(data.status==1){
                            // let data = '<div class="invoice-bills"><div class="table-responsive"><div class="row"><div class="col-md-6">Domain: www.google.com</div><div class="col-md-6">Name: Asad Kamran Shah</div></div><div class="row"><div class="col-md-6">Email: asadkamran297@yahoo.com</div><div class="col-md-6">Phone: 03062049270</div></div><div class="row"><div class="col-md-6">Status: Converted</div><div class="col-md-6">Added By: Converted</div></div><hr><h5>Lead Logs</h5><table class="table table-striped"><thead><tr><th>Item ID</th><th>Description</th></tr></thead><tbody><tr><td>24108054</td><td>Dashlite - Conceptual App Dashboard - Regular License</td></tr></tbody></table></div></div>';
                            // $('#preview_body').append(data)
                            // $('#preview').modal('toggle');
                        }
                    }
                });
        });            
    });
</script>
@endpush