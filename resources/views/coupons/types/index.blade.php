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
                                <h3 class="nk-block-title page-title">Coupon types</h3>
                                <div class="nk-block-des text-soft">
                                    <p>Under this section you will find the list of all coupon types</p>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="more-options">
                                        <ul class="nk-block-tools g-3">
                                            <li class="nk-block-tools-opt">
                                                {{-- <a href="{{ route('tiers.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Add</span></a> --}}
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
                                        <th>Title</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($models) && count($models))
                                    @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->title ?? "---" }}</td>
                                        {{--<td>{{ $model->description ?? "---" }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('tiers.edit',['tier'=>$model->id]) }}" title="Edit" data-toggle="tooltip">
                                                    <em class="icon ni ni-pen2"></em>
                                                </a>
                                                <form action="{{ route('tiers.destroy',['tier'=>$model->id]) }}" method="post" class="ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="" title="Delete" data-toggle="tooltip" onclick="this.closest('form').submit();return false;">
                                                        <em class="icon ni ni-trash"></em>
                                                    </a>
                                                </form>
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

@endsection