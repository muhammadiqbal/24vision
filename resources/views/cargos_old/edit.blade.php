@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cargo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($cargo, ['route' => ['cargos.update', $cargo->id], 'method' => 'patch']) !!}

                        @include('cargos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection