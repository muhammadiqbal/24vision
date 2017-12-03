<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Area1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area1', 'Area1:') !!}
    {!! Form::text('area1', null, ['class' => 'form-control']) !!}
</div>

<!-- Area2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area2', 'Area2:') !!}
    {!! Form::text('area2', null, ['class' => 'form-control']) !!}
</div>

<!-- Area3 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area3', 'Area3:') !!}
    {!! Form::text('area3', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('routes.index') !!}" class="btn btn-default">Cancel</a>
</div>
