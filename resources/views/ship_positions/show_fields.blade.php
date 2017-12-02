<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $shipPosition->id !!}</p>
</div>

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
    {!! Form::label('port_id', 'Port Id:') !!}
    <p>{!! $shipPosition->port->name !!}</p>
</div>

<!-- Date Of Opening Field -->
<div class="form-group">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    <p>{!! $shipPosition->date_of_opening !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $shipPosition->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $shipPosition->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $shipPosition->deleted_at !!}</p>
</div>

