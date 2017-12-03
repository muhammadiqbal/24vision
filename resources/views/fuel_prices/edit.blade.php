@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fuel Price
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($fuelPrice, ['route' => ['fuelPrices.update', $fuelPrice->id], 'method' => 'patch']) !!}

                        @include('fuel_prices.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection