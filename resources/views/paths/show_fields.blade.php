<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $path->id !!}</p>
</div>

<!-- Route Id Field -->
<div class="form-group">
    {!! Form::label('route_id', 'Route Id:') !!}
    <p>{!! isset($path->route_id) ? $path->route->name : null !!}</p>
</div>

<!-- Zone1 Field -->
<div class="form-group">
    {!! Form::label('zone1', 'Zone1:') !!}
    <p>{!! isset($path->zone1) ? $path->zon1->name : null !!}</p>
</div>

<!-- Zone2 Field -->
<div class="form-group">
    {!! Form::label('zone2', 'Zone2:') !!}
    <p>{!! isset($path->zone2) ? $path->zon2->name : null !!}</p>
</div>

<!-- Zone3 Field -->
<div class="form-group">
    {!! Form::label('zone3', 'Zone3:') !!}
    <p>{!! isset($path->zone3) ? $path->zon3->name : null !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $path->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $path->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $path->deleted_at !!}</p>
</div>

