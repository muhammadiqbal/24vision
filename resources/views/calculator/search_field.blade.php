<!-- Ship Id Field -->
<div class="form-group">
    {!! Form::label('ship_id', 'Ship:') !!}
    <select name="ship_id" data-widget="select2" class="form-control">
        @foreach($ships as $ship)
            	<option value="{{$ship->id}}">{{$ship->name}}</option>
        @endforeach
    </select>

<!-- Region Id Field -->
<div class="form-group">
    {!! Form::label('region_id', 'Region:') !!}
    <select name="region_id" data-widget="select2" class="form-control">
        @foreach($regions as $region)
            	<option value="{{$region->id}}">{{$region->name}}</option>
        @endforeach
    </select>
</div>

<!-- Port Id Field -->
<div class="form-group">
    {!! Form::label('port_id', 'Port:') !!}
    <select name="port_id" data-widget="select2" class="form-control">
        @foreach($ports as $port)
            	<option value="{{$port->id}}">{{$port->name}}</option>
        @endforeach
    </select>
</div>

<!-- Radius Field -->
<div class="form-group">
    {!! Form::label('radius', 'Radius:') !!}
     {!! Form::number('radius', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Of Opening Field -->
<div class="form-group">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    {!! Form::date('date_of_opening', null, ['class' => 'form-control']) !!}
</div>