@extends('layouts.app')


@section('content')
Select script ot be executed:
	<div class="form-group col-sm-6">
    {!! Form::label('script', 'Script:') !!}
        <select name="script" id="script" class="form-control">
            <option value="python3 execute_cargo_extraction.py">Cargo extraction</option>
            <option value="python3 execute_ship_extraction.py">Ship extraction</option>
            <option value="python3 execute_order_extraction.py">Order extraction</option>
        </select>
	</div>
	<button id="execute">execute</button>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Execution result</h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="label label-primary"></span>
    </div>
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div class="box-body" id="terminal">
  </div>
  <!-- /.box-body -->


@endsection


@section('script')

$('#execute').click(function() {
    var data = "";
    $.ajax({
        type:"GET",
        url : "{{url('/api/controlPanel/')}}" + $('#script').val(),
        data : 
        async: false,
        success : function(response) {
            data = response;
            $('terminal').append(response);
            return response;
        },
        error: function() {
            alert('Error occured');
        }
    });
});
@endsection