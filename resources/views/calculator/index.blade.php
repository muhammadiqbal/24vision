@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Cargo In Ship matcher</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">@include('calculator.ship_position')</div>
                        <div class="col-sm-6">@include('calculator.occupancy_table')</div>
                    </div>
                    <div class="row">
                       @include('calculator.table') 
                    </div>
            </div>

        </div>
    </div>
@endsection