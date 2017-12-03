@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fuel Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($fuelType, ['route' => ['fuelTypes.update', $fuelType->id], 'method' => 'patch']) !!}

                        @include('fuel_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection