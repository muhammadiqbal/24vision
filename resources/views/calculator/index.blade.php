@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Cargo In Ship matcher </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                  <!-- Apply any bg-* class to to the icon to color it -->
                  <span class="info-box-icon bg-red"><i class="fa fa-envelope"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Mail</span>
                    <span class="info-box-number">{{$mailCount}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                  <!-- Apply any bg-* class to to the icon to color it -->
                  <span class="info-box-icon bg-red"><i class="fa fa-cubes"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Cargo</span>
                    <span class="info-box-number">{{$cargoCount}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-sm-3 col-xs-12">
                <div class="info-box">
                  <!-- Apply any bg-* class to to the icon to color it -->
                  <span class="info-box-icon bg-red"><i class="fa fa-ship"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Ship</span>
                    <span class="info-box-number">{{$shipCount}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-sm-3 col-xs-12">
                
                  <a href="{{url('cargoMap')}}" target="_blank"><span class="info-box-icon bg-red" style="border-radius:100%;"><i class="fa fa-globe" data-toggle="tooltip" title="View cargo Map"></i></span></a>
               
            </div>

         
        </div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                @include('calculator.search_field')
                            </div>
                            <div class="col-md-6">
                                @include('calculator.occupancy_table')
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box box-primary">
                      
                <div class="box-body table-responsive">
                <b style="color: blue;">NULL</b>|
                <b style="color: red;">Manually changed</b>|
                <b style="color: green;">Constructed</b>
                    @include('calculator.table')
                </div>
            </div>
        </div>
    </div>
@endsection