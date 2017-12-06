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
                        <div class="col-md-12">
                        <div class="col-md-6">
                            @include('calculator.search_field')
                        </div>
                        <div class="col-md-2">
                            @include('calculator.occupancy_table')
                        </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('ships.show_fields')
                    <a href="{!! route('ships.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box box-primary">
                       @include('calculator.table') 
            </div>
        </div>
    </div>
@endsection