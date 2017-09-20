<!-- Ship Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_id', 'Ship Id:') !!}
    {!! Form::number('ship_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Region Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('region_id', 'Region Id:') !!}
    {!! Form::number('region_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Port Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('port_id', 'Port Id:') !!}
    {!! Form::number('port_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_of_opening', 'Date Of Opening:') !!}
    {!! Form::date('date_of_opening', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('shipPositions.index') !!}" class="btn btn-default">Cancel</a>
</div>
