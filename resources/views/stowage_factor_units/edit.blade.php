@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Stowage Factor Unit
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($stowageFactorUnit, ['route' => ['stowageFactorUnits.update', $stowageFactorUnit->id], 'method' => 'patch']) !!}

                        @include('stowage_factor_units.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection