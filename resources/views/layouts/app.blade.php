@extends('adminlte::page')

@vite(['resources/css/app.css', 'resources/js/app.js'])
@section('title', 'Dashboard')



@if (isset($header))
    @section('content_header')
    <div class="container-fluid">
        <h1>{{ $header }}</h1>
    </div>
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
    <!-- <script src="/js/app.js"></script> -->
    @include('sweetalert::alert')
    <!-- <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script> -->
@stop


