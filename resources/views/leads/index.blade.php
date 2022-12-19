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
                                <h3 class="nk-block-title page-title">Leads</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all leads</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                @can('permission',43)
                                                <a href="{{ route('leads.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a>
                                                @endcan
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
                                        <th>ID</th>
                                        <th>Domain</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        {{-- <th>Lead Status</th> --}}
                                        {{-- <th>Added By</th> --}}
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model['domain']->name ?? "---" }}</td>
                                        <td>{{ $model->name ?? "---" }}</td>
                                        <td>{{ $model->email ?? "---" }}</td>
                                        <td>{{ $model->phone ?? "---" }}</td>
                                        {{-- <td>
                                            <select name="lead_status_id" @if($model->lead_status_id==2) disabled="" @endif data-lead-id="{{ $model->id }}" class="form-control lead_status">
                                                @if(isset($statuses) && count($statuses))
                                                @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" @if($status->id==$model->lead_status_id) selected="selected" @endif>{{ $status->title }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td> --}}
                                        {{-- <td>{{ $model['user']->name ?? "Website" }}</td> --}}
                                        <td>{{ formattedTimeDate($model->created_at) ?? "---" }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                    {{-- <a href="{{ route('leads.edit',['lead'=>$model->id]) }}" title="Edit" data-toggle="tooltip">
                                                        <em class="icon ni ni-pen2"></em>
                                                    </a> --}}
                                                    @if($model->lead_status_id==3)
                                                    {{-- @can('permission',42) --}}
                                                    <a href="javascript::" class="add_comments ml-1" data-lead-email="{{ $model->email }}" data-lead-id="{{ $model->id }}" title="Add Remarks" data-toggle="tooltip">
                                                        <em class="icon ni ni-plus"></em>
                                                    </a>
                                                    {{-- @endcan --}}
                                                    @endif
                                                    @if($model->lead_status_id==2)
                                                    @else 
                                                    {{-- <a class="ml-1" href="{{ route('orders.convert_to_order',['lead'=>$model->id,'domain'=>$model['domain']->id]) }}" title="Convert To Order" data-toggle="tooltip">
                                                        <em class="icon ni ni-check-circle"></em>
                                                    </a> --}}
                                                    @can('permission',46)
                                                    <a href="javascript::" class="followup_email ml-1" data-lead-id="{{ $model->id }}" title="Send Followup Email" data-toggle="tooltip">
                                                        <em class="icon ni ni-mail"></em>
                                                    </a>
                                                    @endcan
                                                    @endif
                                                    @can('permission',48)
                                                    <a class="ml-1" href="{{ route('leads.logs',['lead'=>$model->id]) }}" data-lead-id="{{ $model->id }}" title="Logs" data-toggle="tooltip">
                                                        <em class="icon ni ni-file-docs"></em>
                                                    </a>
                                                    @endcan
                                                    @can('permission',47)
                                                    <a href="javascript::" class="preview ml-1" data-lead-id="{{ $model->id }}" data-route-url="{{ route('leads.show',['lead'=>$model->id]) }}" title="Preview Lead" data-toggle="tooltip">
                                                        <em class="icon ni ni-eye"></em>
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

                if(this.value==3)
                {
                    $('.lead_id').val(lead_id)
                    $('#followup_comments_modal').modal('toggle');
                }
                else
                {
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
                        if(data.status==1)
                        {
                            const comments =  data.lead.comments.map((item)=>{
                                return '<tr><td>'+item.user.name+'</td><td>'+item.comment+'</td><td>'+item.created_at+'</td></tr>'
                            }).join('');
                            let a = '<div class="invoice-bills"><div class="table-responsive"><div class="row"><div class="col-md-6">Domain:'+data.lead.domain.name+'</div><div class="col-md-6">Name: '+data.lead.name+'</div></div><div class="row"><div class="col-md-6">Email: '+data.lead.email+'</div><div class="col-md-6">Phone: '+data.lead.phone+'</div></div><div class="row"><div class="col-md-6">Status: '+data.lead.status.title+'</div><div class="col-md-6">Added By: '+data.lead.user.name+'</div></div><hr><h5>Remarks</h5><table class="table table-striped"><thead><tr><th>Added By</th><th>Remarks</th><th>Date time</th></tr></thead><tbody>'+comments+'</tbody></table></div></div>';
                            $('.preview_body').html(a);
                            $('#preview').modal('toggle');
                        }
                    }
                });
            });            
        });
    </script>
    @endpush