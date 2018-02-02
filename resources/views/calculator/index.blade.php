@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Cargo In Ship matcher </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

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
                <div class="col-sm-12">
                    <div class="col-sm-4">
                        {!! Form::label('status', 'Status:') !!}
                        <select id="statusoption" class="form-control">
                            <option value="1">OK</option>
                            <option value="2">Review</option>
                            <option value="3">Unusable</option>
                            <option value="4">Incomplete</option>
                        </select>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    @include('calculator.table')
                </div>
            </div>
        </div>
    </div>
@endsection