<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $zone->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $zone->name !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('zone_points', 'Zone Points:') !!}
    @foreach($zone->zonePoints as $zone_point)
        <p>{!! $zone_point->latitude !!}, {!! $zone_point->longitude !!}</p>
    @endforeach
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $zone->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $zone->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $zone->deleted_at !!}</p>
</div>

