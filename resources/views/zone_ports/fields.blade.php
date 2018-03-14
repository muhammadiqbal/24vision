<!-- Port Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('port_id', 'Port Id:') !!}
    {!! Form::number('port_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Zone Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone_id', 'Zone Id:') !!}
    {!! Form::number('zone_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('zones.index') !!}" class="btn btn-default">Cancel</a>
</div>
