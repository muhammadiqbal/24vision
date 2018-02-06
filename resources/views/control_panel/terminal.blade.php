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
	<textarea id="terminal">
		
	</textarea>
@endsection


@section('script')

$('#script').change(function() {
    var data = "";
    $.ajax({
        type:"GET",
        url : "{{url('/api/controlPanel/')}}" + $(this).val(),
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