<!-- Start Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_port', 'Start Port:') !!}
    {!! Form::number('start_port', null, ['class' => 'form-control']) !!}
</div>

<!-- End Port Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_port', 'End Port:') !!}
    {!! Form::number('end_port', null, ['class' => 'form-control']) !!}
</div>

<!-- Distance Field -->
<div class="form-group col-sm-6">
    {!! Form::label('distance', 'Distance:') !!}
    {!! Form::number('distance', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('distances.index') !!}" class="btn btn-default">Cancel</a>
</div>
