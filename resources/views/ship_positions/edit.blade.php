@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ship Position
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($shipPosition, ['route' => ['shipPositions.update', $shipPosition->id], 'method' => 'patch']) !!}

                        @include('ship_positions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection