@extends('adminlte::layouts.app')


@section('htmlheader_title')
    Tower
@endsection


@section('contentheader_title')
    <br>
    <br>
    @include('adminlte::pages.tower.partials.dashboard-heder')
@endsection


@section('contentheader_description')
@endsection


@section('page-name')

@endsection

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"/>

@section('main-content')
<div class="container">
    <div class="col-lg-12" class="container-fluid spark-screen">
        <div class="panel panel-default">
            <div class="panel-body">
                @include('adminlte::pages.tower.partials.broadcast_view_crud')
            </div>
        </div>
    </div>

    <div class="col-lg-4" class="container-fluid spark-screen">
        <div class="panel panel-default">
            <div class="panel-body">
            @include('adminlte::pages.tower.partials.ip_view_crud')
        </div>
        </div>
    </div>

    <div class="col-lg-8" class="container-fluid spark-screen">
        <div class="panel panel-default">
            <div class="panel-body">
                @include('adminlte::pages.tower.partials.link_view_crud')
            </div>
        </div>
    </div>
</div>
@endsection


@section('page-scripts')
    @include('adminlte::pages.tower.partials.ip_secript_crud')
    @include('adminlte::pages.tower.partials.broadcast_secript_crud')
@endsection
