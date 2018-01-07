@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Zone Point
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('zone_points.show_fields')
                    <a href="{!! route('zonePoints.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
