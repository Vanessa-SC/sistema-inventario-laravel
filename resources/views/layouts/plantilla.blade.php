@extends('adminlte::page')

@section('title', 'InventApp')

@section('content_header')
@yield('header')
@stop

@section('content')
<div class="container p-2">
    @yield('content')
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/custom.css">
<link rel="stylesheet" href="/css/colors.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@livewireStyles
<!-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> -->
@stop

@section('js')
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@livewireScripts
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
@yield('jscript')
@stop