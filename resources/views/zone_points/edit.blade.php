@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Zone Point
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($zonePoint, ['route' => ['zonePoints.update', $zonePoint->id], 'method' => 'patch']) !!}

                        @include('zone_points.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection