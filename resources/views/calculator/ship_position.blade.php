<!-- Ship Id Field -->
<div class="form-group">
    {!! Form::label('ship_id', 'Ship:') !!}
    <select name="ship_id" data-widget="select2" class="form-control">
        @foreach($ships as $ship)
            @if( $shipPosition->ship_id == $ship->id)
            	<option value="{{$ship->id}}" selected="true">{{$ship->name}}</option>
            @else
            	<option value="{{$ship->id}}">{{$ship->name}}</option>
        	@endif
        @endforeach
    </select>

<!-- Region Id Field -->
<div class="form-group">
    {!! Form::label('region_id', 'Region:') !!}
    <select name="region_id" data-widget="select2" class="form-control">
        @foreach($regions as $region)
	        @if( $shipPosition->region_id == $region->id)
	            <option value="{{$region->id}}" selected="true">{{$region->name}}</option>
	        @else
            	<option value="{{$region->id}}">{{$region->name}}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Port Id Field -->
<div class="form-group">
    {!! Form::label('port_id', 'Port:') !!}
    <select name="port_id" data-widget="select2" class="form-control">
        @foreach($ports as $port)
        	@if( $shipPosition->port_id == $port->id)
	            <option value="{{$port->id}}" selected="true">{{$port->name}}</option>
	        @else
            	<option value="{{$port->id}}">{{$port->name}}</option>
        	@endif
        @endforeach
    </select>
</div>

<!-- Position X Field -->
<div class="form-group">
    {!! Form::label('position_x', 'Position X:') !!}
    <p></p>
</div>

<!-- Position Y Field -->
<div class="form-group">
    {!! Form::label('position_x', 'Position Y:') !!}
    <p></p>
</div>

<!-- Radius Field -->
<div class="form-group">
    {!! Form::label('radius', 'Radius:') !!}
    <p></p>
</div>

<!-- Date Of Opening Field -->
<div class="form-group">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    <p>{!! $shipPosition->date_of_opening !!}</p>
</div>