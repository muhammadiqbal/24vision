<!-- Zone Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone_id', 'Zone Id:') !!}
    {!! Form::number('zone_id', null, ['class' => 'form-control', 'value'=>{{$_GET['id']}}]) !!}
</div>

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Longitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::number('longitude', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('zonePoints.index') !!}" class="btn btn-default">Cancel</a>
</div>
