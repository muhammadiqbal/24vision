<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Rate Type Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rate_type_factor', 'Rate Type Factor:') !!}
    {!! Form::number('rate_type_factor', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ldRateTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
