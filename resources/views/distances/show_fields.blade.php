<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $distance->id !!}</p>
</div>

<!-- Start Port Field -->
<div class="form-group">
    {!! Form::label('start_port', 'Start Port:') !!}
    <p>{!! $distance->startPort->name !!}</p>
</div>

<!-- End Port Field -->
<div class="form-group">
    {!! Form::label('end_port', 'End Port:') !!}
    <p>{!! $distance->endPort->name !!}</p>
</div>

<!-- Distance Field -->
<div class="form-group">
    {!! Form::label('distance', 'Distance:') !!}
    <p>{!! $distance->distance !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $distance->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $distance->updated_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', 'Deleted At:') !!}
    <p>{!! $distance->deleted_at !!}</p>
</div>

