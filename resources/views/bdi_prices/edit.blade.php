@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bdi Price
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bdiPrice, ['route' => ['bdiPrices.update', $bdiPrice->id], 'method' => 'patch']) !!}

                        @include('bdi_prices.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection