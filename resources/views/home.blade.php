@extends('layouts.app')

@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <h1 class="text-center">{{ config('app.name', 'Welcome') }}</h1>
</div>
@endsection
@section('scripts')
@endsection
