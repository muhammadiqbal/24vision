<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $zonePoint->id !!}</p>
</div>

<!-- Zone Id Field -->
<div class="form-group">
    {!! Form::label('zone_id', 'Zone Id:') !!}
    <p>{!! isset($zonePoint->zone_id) ? $zonePoint->zone->name : null !!}</p>
</div>

<!-- Latitude Field -->
<div class="form-group">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{!! $zonePoint->latitude !!}</p>
</div>

<!-- Longitude Field -->
<div class="form-group">
    {!! Form::label('longitude', 'Longitude:') !!}
    <p>{!! $zonePoint->longitude !!}</p>
</div>

<!-- Position Field -->
<div class="form-group">
    {!! Form::label('position', 'Position:') !!}
    <p>{!! $zonePoint->position !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $zonePoint->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $zonePoint->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $zonePoint->deleted_at !!}</p>
</div>

