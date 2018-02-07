@extends('layouts.app')


@section('content')

<div class="box primary">
<div class="box-body">	
	<div class="row">
		<div class="form-group col-sm-6">
		<b>Select script ot be executed</b>
	    {{-- {!! Form::label('script', 'Script:') !!}
	        <select name="script" id="script" class="form-control">
	            <option value="python3 execute_cargo_extraction.py">Cargo extraction</option>
	            <option value="python3 execute_ship_extraction.py">Ship extraction</option>
	            <option value="python3 execute_order_extraction.py">Order extraction</option>
	        </select>
		</div> --}}
		<div class="form-group col-sm-12">
		<b>OR Type the shell command</b>
	    {!! Form::label('script', 'command:') !!}
	        <input type="text" name="script" id="script">
		</div>

		<!-- Submit Field -->
		<div class="form-group col-sm-12">
		  
		    <a id="execute" class="btn btn-default">Execute</a>
		</div>
	</div>
</div>
</div>


<div class="box box-priamry">
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
</div>

@endsection


@section('scripts')
<script type="text/javascript">
$('#execute').click(function() {
    var data = "";
    $.ajax({
        type:"GET",
        url : "{{url('/api/controlPanel/')}}",
        data :{script:$('#script').val()}
        success : function(response) {
            data = response;
            $('#terminal').text("<p>"+data+"</p>");
            alert("command/script executed. result:"+data);
            return response;
        },
        error: function() {
            alert('Error occured');
        }
    });
});
</script>
@endsection