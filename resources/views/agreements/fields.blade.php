<!-- Ship Position Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_position_id', 'Ship Position Id:') !!}
    {!! Form::number('ship_position_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Cargo Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cargo_id', 'Cargo Id:') !!}
    {!! Form::number('cargo_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('agreements.index') !!}" class="btn btn-default">Cancel</a>
</div>
