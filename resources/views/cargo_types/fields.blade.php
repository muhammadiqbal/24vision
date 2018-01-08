<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Standard Stowage Factor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('standard_stowage_factor', 'Standard Stowage Factor:') !!}
    {!! Form::number('standard_stowage_factor', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cargoTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
