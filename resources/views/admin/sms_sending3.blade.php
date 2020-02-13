@extends('adminlte::page')


@section('demo')
@section('content')
{!! $dataTable->table() !!}

@endsection


@push('scripts')
{!! $dataTable->scripts() !!}
@endpush


@stop

