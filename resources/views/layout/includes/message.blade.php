@if( $message = session('success') )
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fa fa-check"></i>
        {!! $message !!}
    </div>
@endif

@if( $message = session('error') )
    <div class="alert alert-danger my-0">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fa fa-ban"></i> {!! $message !!}
    </div>
@endif