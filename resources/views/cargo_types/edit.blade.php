@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cargo Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($cargoType, ['route' => ['cargoTypes.update', $cargoType->id], 'method' => 'patch']) !!}

                        @include('cargo_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection