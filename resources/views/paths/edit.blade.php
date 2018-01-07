@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Path
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($path, ['route' => ['paths.update', $path->id], 'method' => 'patch']) !!}

                        @include('paths.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection