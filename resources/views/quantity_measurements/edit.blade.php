@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Quantity Measurement
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($quantityMeasurement, ['route' => ['quantityMeasurements.update', $quantityMeasurement->id], 'method' => 'patch']) !!}

                        @include('quantity_measurements.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection