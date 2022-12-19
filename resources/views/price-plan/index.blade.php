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
                                    <h3 class="nk-block-title page-title">Prices</h3>
                                    <form action="{{ route('price_plans.import') }}" method="POST" enctype="multipart/form-data">
                                        <div style="display: flex">

                                            @csrf
                                            <div class="container">
                                                <div class="form-group" style="display: flex">
                                                    <label class="form-label" style="padding-right: 20px">Domain:</label>
                                                    <div class="form-control-wrap" style="width: 200px">
                                                        <select id="domain_id" name="domain_id" class="form-select form-control form-control-lg DomainSelect"  data-search="on">
                                                        </select>
                                                        @if ($errors->has('domain_id'))
                                                        <span class="error">{{ $errors->first('domain_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @can('permission',20)
                                            <div class="container">
                                                <input type="button" id="export" class="btn btn-primary" style="color: white" value="Export">
                                            </div>
                                            @endcan
                                            @can('permission',19)
                                            <div class="form-inline">
                                                <input type="file" name="file">
                                                @if ($errors->has('file'))
                                                <span class="error">{{ $errors->first('file') }}</span>
                                                @endif
                                                <input type="submit" class="btn btn-primary" style="color: white" value="Import">
                                            </div>
                                            @endcan
                                        </div>
                                    </form>


                                </div>
                                <div class="nk-block-head-content">
                                    <ul class="nk-block-tools g-3">
                                        @can('permission',16)
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#" data-toggle="modal" data-target="#addPricePlanModal"><span>Add New</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        @endcan
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card card-preview">
                            <div class="card-inner">
                                <table class="{{-- datatable-init --}} price-datatable nowrap nk-tb-list nk-tb-ulist dataTable no-footer" data-auto-responsive="false">
                                    <thead>
                                        <th>Id</th>
                                        <th>Domain</th>
                                        <th>Type of work</th>
                                        <th>Level</th>
                                        <th>Urgency</th>
                                        <th>Price</th>
                                        <th>Created at</th>
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
<!-- Add Price Plan Modal -->
<div class="modal fade zoom" tabindex="-1" id="addPricePlanModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Price Plan</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <form id="addPricePlanForm">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Domain <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="domain_id" class="form-select form-control form-control-lg DomainSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Type of work <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="price_plan_type_of_work_id" class="form-select form-control form-control-lg pricePlanTypeOfWorksSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Level <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="price_plan_level_id" class="form-select form-control form-control-lg pricePlanLevelsSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Urgencies <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="price_plan_urgency_id" class="form-select form-control form-control-lg pricePlanUrgenciesSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label" >Price <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input name="price" type="text" class="form-control" placeholder="Price">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Price Plan Modal -->

<!-- Add Price Plan Modal -->
<div class="modal fade zoom" tabindex="-1" id="editPricePlanModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Price Plan</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <form id="editPricePlan">
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Type of work <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="type_of_work_id" class="form-select form-control form-control-lg pricePlanTypeOfWorksSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Level <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="level_id" class="form-select form-control form-control-lg pricePlanLevelsSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Urgencies <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <select name="urgency_id" class="form-select form-control form-control-lg pricePlanUrgenciesSelect" data-search="on">
                                    </select>
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Price <span class="text-danger">*</span></label>
                                <div class="form-control-wrap">
                                    <input name="price" type="text" class="form-control" placeholder="Price">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Price Plan Modal -->
@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        function getPricePlans() 
        {
            $('.price-datatable').DataTable().destroy();
            $.fn.dataTable.ext.errMode = 'none';
            var url = "{{route('price_plans.get')}}";
            table = $('.price-datatable').DataTable({
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
                            'domain_id':$('#domain_id').val()
                        }
                    },
                    columns: [
                    {
                        data: 'id',
                        render: function (data, type, row) {
                            return row.id;
                        },
                        // searchable: false,
                        // orderable: false
                    },
                    {
                        data: 'domain.name',
                        name: 'domain.name',
                    },
                    {
                        data: 'type_of_work.name',
                        name: 'type_of_work.name',
                    },
                    {
                        data: 'level.name',
                        name: 'level.name',
                    },
                    {
                        data: 'urgency.name',
                        name: 'urgency.name',
                    },
                    {
                        data: 'price',
                    },
                    {
                        name: 'created_at',
                        data: 'created_at',
                    },
                    {
                        // {{ url('orders').'/delete/' }}${row.id}"
                        data: 'action',
                        render: function (data, type, row) {
                            return `<div class="drodown">
                            <a class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right" style="">
                            <ul class="link-list-opt no-bdr">
                            <li><a href="{{ url('price-plans/edit/') }}/${row.id}"><em class="icon ni ni-focus"></em><span>Edit</span></a></li>
                            <li><a href="{{ url('price-plans/delete/') }}/${row.id}"><em class="icon ni ni-trash-fill"></em><span>Edit</span></a></li>
                            </ul>
                            </div>
                            </div>`;
                        },
                        searchable: false,
                        orderable: false
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

        function pricePlanLevelsSelect() 
        {
            $('.pricePlanLevelsSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_levels.autocomplete')}}";
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

        function pricePlanUrgenciesSelect() 
        {
            $('.pricePlanUrgenciesSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_urgencies.autocomplete')}}";
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

        function pricePlanTypeOfWorksSelect() 
        {
            $('.pricePlanTypeOfWorksSelect').select2({
                width: '100%',
                minimumInputLength: 0,
                dataType: 'json',
                placeholder: 'Select',
                ajax: {
                    url: function () {
                        return "{{route('price_plan_type_of_works.autocomplete')}}";
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

        function getCount() 
        {
            $.ajax({
                url: "{{ route('price_plans.getCount') }}",
                type: "GET",
                dataType: 'json',
                success: function (data) {
                    if (!data.error) {
                        $('.count').text(data)
                    } 
                },
                error: function (data) {
                }
            })
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

        $("#addPricePlanModal, #editPricePlanModal").on("hidden.bs.modal", function () {
            $('#addPricePlanForm').trigger("reset");
            $('#editPricePlanForm').trigger("reset");
            $(".pricePlanLevelsSelect").empty().trigger('change');
            $(".pricePlanUrgenciesSelect").empty().trigger('change');
            $(".pricePlanTypeOfWorksSelect").empty().trigger('change');

            resetValidationErrors($('#addPricePlanForm'))
            resetValidationErrors($('#editPricePlanForm'))
        });

        $('#export').on('click', function(e) {
          console.log('here it is');
          console.log('$("#domain_id").val()',$("#domain_id").val());
          if($("#domain_id").val() == null)
          {
              alert('Please Select Export');
              return false;
          }
          window.location.href = "{{ url('price-plans/export/') }}"+"/"+$("#domain_id").val();
      });

        
        $('#addPricePlanForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('price-plans.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (!data.errors) {
                        toastr.success(data.message);
                        $('#addPricePlanModal').modal('hide');
                        $('#addPricePlanForm').trigger("reset");
                        table.draw();
                        getCount();
                    } else {
                        //validation errors

                    }
                },
                error: function (response) {
                    resetValidationErrors($('#addPricePlanForm'))
                    handleValidationErrors($('#addPricePlanForm'), response.responseJSON.errors)
                }
            });
        });

        $('#domain_id').on('change',function(){
            console.log("$('#domain_id').val()",$('#domain_id').val());
            getPricePlans();
        });
        
        getCount();
        pricePlanLevelsSelect();
        pricePlanUrgenciesSelect();
        pricePlanTypeOfWorksSelect();
        getPricePlans();
        DomainSelect();
    });
</script>
@endpush