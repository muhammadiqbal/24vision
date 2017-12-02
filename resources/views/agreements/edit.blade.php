@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Agreement
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($agreement, ['route' => ['agreements.update', $agreement->id], 'method' => 'patch']) !!}

                        @include('agreements.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection