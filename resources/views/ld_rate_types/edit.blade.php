@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ld Rate Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($ldRateType, ['route' => ['ldRateTypes.update', $ldRateType->id], 'method' => 'patch']) !!}

                        @include('ld_rate_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection