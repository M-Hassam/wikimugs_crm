@extends('layout.app')


@section('content')

@can('edit articles')
  <p>Checking</p>
@endcan

@endsection