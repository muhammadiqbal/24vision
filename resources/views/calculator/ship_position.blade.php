<!-- Ship Id Field -->
<div class="form-group">
    {!! Form::label('ship_id', 'Ship Id:') !!}
    <p>{!! $shipPosition->ship->name !!}</p>
</div>

<!-- Region Id Field -->
<div class="form-group">
    {!! Form::label('region_id', 'Region Id:') !!}
    <p>{!! $shipPosition->region->name !!}</p>
</div>

<!-- Port Id Field -->
<div class="form-group">
    {!! Form::label('port_id', 'Port:') !!}
    <p>{!! $shipPosition->port->name !!}</p>
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