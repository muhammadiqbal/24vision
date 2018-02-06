@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Zone
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('zones.show_fields')
                    <h1>Zone Point</h1>
                    <h1 class="pull-right">
                       <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('zonePoints.create') !!}">Add Zone Points</a>
                    </h1>
                    @foreach($zone->zonePoints() as $point)
                        <p>latitude: <b>{{$point->latitude}}</b></p>
                        <p>longitude: <b>{{$point->longitude}}</b></p>
                    @endforeach
                    <a href="{!! route('zones.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
