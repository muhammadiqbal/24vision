@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Cargos</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('cargos.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
            
            @if($cargos->count>0)
                    @include('cargos.table')
            @else
                <b>No cargo fund in this port</b>
            @endif
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
            @if($shipPositions->count>0)
                    @include('ship_positions.table')
            @else
                 <b>No cargo fund in this port</b>
            @endif
            </div>
        </div>
    </div>
@endsection

