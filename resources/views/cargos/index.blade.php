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
        <div class="col-sm-12" style="top:10px; bottom:5px;">
        <form method="GET" id="search-form" class="form-inline" role="form">
            {{-- <div class="form-group col-sm-3">
                {!! Form::label('status', 'Status:') !!}
                <select name="statusoption" id="statusoption" class="form-control">
                    <option value="1">OK</option>
                    <option value="2">Review</option>
                    <option value="3">Unusable</option>
                    <option value="4">Incomplete</option>
                </select>
            </div> --}}

             <div class="form-group col-sm-3">
                {!! Form::label('cargo_status', 'Cargo status:') !!}
                <br>
                <input type="checkbox" value="1" name="statusoption[]">OK
                <input type="checkbox" value="2" name="statusoption[]"> Review<br>
                <input type="checkbox" value="3" name="statusoption[]">Unusable
                <input type="checkbox" value="4" name="statusoption[]">Incomplte
            </div>

            
            <!-- Laycan First Day Field -->
            <div class="form-group col-sm-3">
                {!! Form::label('laycan_first_day', 'Laycan First Day:') !!}
                {!! Form::date('laycan_first_day', null, ['class' => 'form-control']) !!}
            </div>
            <!-- Laycan Last Day Field -->
            <div class="form-group col-sm-3">
                {!! Form::label('laycan_last_day', 'Laycan Last Day:') !!}
                {!! Form::date('laycan_last_day', null, ['class' => 'form-control']) !!}
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        </div>
        

            <div class="box-body table-responsive">
            <b style="color: blue;">NULL</b>|
            <b style="color: red;">Manually changed</b>|
            <b style="color: green;">Constructed</b>
                    @include('cargos.table')
            </div>
        </div>
    </div>
    @include('emails.modal')
    
@endsection


