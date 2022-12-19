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
                                <h3 class="nk-block-title page-title">Completed Orders</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all completed orders</p>
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
                                        <th>ID</th>
                                        <th>Order ID</th>
                                        <th>Pages</th>
                                        <th>Type Of Work</th>
                                        <th>Subject</th>
                                        <th>Topic</th>
                                        <th>Deadline</th>
                                        <th>Submission Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id ?? "---" }}</td>
                                        <td>{{ $model->order_no ?? "---" }}</td>
                                        <td>{{ $model->no_of_pages->name ?? "---" }}</td>
                                        <td>{{ $model->type_of_work->name ?? "---" }}</td>
                                        <td>{{ $model->subjects->name ?? "---" }}</td>
                                        <td>{{ $model->topic ?? "---" }}</td>
                                        <td>{{ isset($model->writer_deadline) ? formattedDate($model->writer_deadline) : "---" }}</td>
                                        <td>{{ isset($model->writer_submit_date) ? formattedDate($model->writer_submit_date) : "---" }}</td>
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