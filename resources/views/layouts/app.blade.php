@extends('adminlte::page')

@section('title', 'Dashboard')

@if (isset($header))
    @section('content_header')
        <h1>{{ $header }}</h1>
    @stop
@endif

@section('content')
    {{ $slot }}
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
