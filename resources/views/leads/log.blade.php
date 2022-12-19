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
                                <h3 class="nk-block-title page-title">All logs of lead {{ $lead_id ?? "" }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card card-preview">
                        <div class="card-inner">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>lOG</th>
                                        <th>Date Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->description ?? "---" }}</td>
                                        <td>{{ $model->created_at ?? "---" }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>No data found</td>
                                        <td></td>
                                    </tr>
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