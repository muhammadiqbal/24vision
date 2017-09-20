@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Port
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($port, ['route' => ['ports.update', $port->id], 'method' => 'patch']) !!}

                        @include('ports.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection