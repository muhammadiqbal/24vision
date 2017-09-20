@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Freight Idea Measurement
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($freightIdeaMeasurement, ['route' => ['freightIdeaMeasurements.update', $freightIdeaMeasurement->id], 'method' => 'patch']) !!}

                        @include('freight_idea_measurements.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection