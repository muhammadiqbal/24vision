@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Bdi Code
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bdiCode, ['route' => ['bdiCodes.update', $bdiCode->id], 'method' => 'patch']) !!}

                        @include('bdi_codes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection