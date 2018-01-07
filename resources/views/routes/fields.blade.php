<!-- Zone1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone1', 'Zone1:') !!}
    {!! Form::number('zone1', null, ['class' => 'form-control']) !!}
</div>

<!-- Zone2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone2', 'Zone2:') !!}
    {!! Form::number('zone2', null, ['class' => 'form-control']) !!}
</div>

<!-- Zone3 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zone3', 'Zone3:') !!}
    {!! Form::number('zone3', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('routes.index') !!}" class="btn btn-default">Cancel</a>
</div>
