<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $agreement->id !!}</p>
</div>

<!-- Ship Position Id Field -->
<div class="form-group">
    {!! Form::label('ship_position_id', 'Ship Position Id:') !!}
    <p>{!! $agreement->ship_position_id !!}</p>
</div>

<!-- Cargo Id Field -->
<div class="form-group">
    {!! Form::label('cargo_id', 'Cargo Id:') !!}
    <p>{!! $agreement->cargo_id !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $agreement->deleted_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $agreement->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $agreement->updated_at !!}</p>
</div>

