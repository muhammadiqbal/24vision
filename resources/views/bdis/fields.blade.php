<!-- Ship Id Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('ship_id', 'Ship Id:') !!}
    {!! Form::number('ship_id', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Ship Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ship_id', 'Ship :') !!}
    <select name="ship_id" class="form-control">
        @foreach($ships as $ship)
            <option value="{{$ship->id}}">{{$ship->name}}</option>
        @endforeach
    </select>
</div>


{{-- <!-- Route Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('route_id', 'Route Id:') !!}
    {!! Form::number('route_id', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Ship Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('route_id', 'Route :') !!}
    <select name="route_id" class="form-control">
        @foreach($routes as $route)
            <option value="{{$ship->id}}">{{$ship->name}}</option>
        @endforeach
    </select>
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('bdis.index') !!}" class="btn btn-default">Cancel</a>
</div>