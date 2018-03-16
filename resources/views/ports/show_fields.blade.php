<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $port->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $port->name !!}</p>
</div>

<!-- Zone Id Field -->
<div class="form-group">
    {!! Form::label('zone_id', 'Zone Id:') !!}
    <p>{!! $port->zone->name !!}</p>
</div>

<!-- Max Laden Draft Field -->
<div class="form-group">
    {!! Form::label('max_laden_draft', 'Max Laden Draft:') !!}
    <p>{!! $port->max_laden_draft !!}</p>
</div>

<!-- Latitude Field -->
<div class="form-group">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{!! $port->latitude !!}</p>
</div>

<!-- Longitude Field -->
<div class="form-group">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{!! $port->longitude !!}</p>
</div>

<!-- Draft Factor Field -->
<div class="form-group">
    {!! Form::label('draft_factor', 'Draft Factor:') !!}
    <p>{!! $port->draft_factor !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $port->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $port->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $port->deleted_at !!}</p>
</div>

