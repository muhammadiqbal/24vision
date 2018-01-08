@extends('layouts.app')

@section('content')
    Date:
    Range: 
    @include('ships.fields')
    @include('cargos.fields')
    @include('ports.fields')
    @include('ports.fields')

    <h1>Calculation</h1>

    <div class="form-group col-sm-6">
        {!! Form::label('route', 'Route:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('bdi', 'BDI:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fuel_price', 'Fuel Price:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fuel_consumption', 'Fuel Consumption:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('fuel_cost', 'Fuel cost:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('remaining_size', 'Remaining Size:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('remaining_tonnage', 'Remaining Tonnage:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('draft', 'Draft:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('non_hire_cost', 'Non Hire Cost:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('ntce', 'NTCE:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('range_to_start', 'Range to Start:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('distance_to_start', 'Distance to Start:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('distance_start_to_end', 'Distance Start to End:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('distance_total', 'Distance Total:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('days_to_start', 'Days to Start:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('days_to_end', 'Days to End:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('port_time', 'Port Time:') !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('voyage_time', 'Voyage Time:') !!}
    </div>
@endsection

