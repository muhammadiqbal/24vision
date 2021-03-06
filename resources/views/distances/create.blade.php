@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            Distance
        </h1>
    </section>
     @include('flash::message')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'distances.store']) !!}

                    <!-- Start Port Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('start_port', 'Start Port:') !!}
                        <select name="start_port" class="form-control">
                            @foreach($ports as $port)
                                <option value="{{$port->id}}">{{$port->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- End Port Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('end_port', 'End Port:') !!}
                        <select name="end_port" class="form-control">
                            @foreach($ports as $port)
                                <option value="{{$port->id}}">{{$port->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('distances.index') !!}" class="btn btn-default">Cancel</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
