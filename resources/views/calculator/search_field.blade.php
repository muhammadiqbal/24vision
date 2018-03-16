{!! Form::open(['url' => ['/home'], 'method' => 'GET']) !!}

<!-- Ship Id Field -->
<div class="form-group col-sm-8">
    {!! Form::label('ship_id', 'Ship*:') !!}
    <select name="ship_id" class="form-control" required="true">
        <option value=""></option>
        @foreach($ships as $ship)
                <option 
                    @if($selectedShip && $selectedShip->id == $ship->id)
                        {{'selected="true"'}}
                    @endif
                    value="{{$ship->id}}">{{$ship->name}}
                </option>
        @endforeach
    </select>
</div>

<!-- Occupied size Field -->
<div class="form-group col-sm-4">
    {!! Form::label('occupied_size', 'Occupied size:') !!}
    {!! Form::number('occupied_size',null, ['class' => 'form-control', 'value'=>$occupied_size, 'min'=>0]) !!}
</div>

<!-- Port Id Field -->
<div class="form-group col-sm-8">
    {!! Form::label('port_id', 'Port*:') !!}
    <select name="port_id" class="form-control" required="true">
        <option value=""></option>
        @foreach($ports as $port)
                <option 
                    @if($selectedPort && $selectedPort->id == $port->id)
                        {{'selected="true"'}}
                    @endif
                    value="{{$port->id}}">{{$port->name}}
                </option>
        @endforeach
    </select>
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('occupied_tonage', 'Occupied tonage:') !!}
    {!! Form::number('occupied_tonage',null, ['class' => 'form-control', 'value'=>$occupied_tonage, 'min'=>0]) !!}
</div>

 <div class="col-sm-4">
    {!! Form::label('cargo_status', 'Cargo status:') !!}
{{--     <select name="cargo_status[]" class="form-control select2" data-widget="select2" multiple="true" placehoder="select status(es)">
        <option >All</option>
        <option value="1">OK</option>
        <option value="2">Review</option>
        <option value="3">Unusable</option>
        <option value="4">Incomplete</option>
    </select> --}}
    <br>
    <input type="checkbox" value="1" name="cargo_status[]">OK
    <input type="checkbox" value="2" name="cargo_status[]"> Review<br>
    <input type="checkbox" value="3" name="cargo_status[]">Unusable
    <input type="checkbox" value="4" name="cargo_status[]">Incomplte
</div>

<!-- Range Field -->
<div class="form-group col-sm-4">
    {!! Form::label('Range', 'Range:') !!}
    {!! Form::number('range',null, ['class' => 'form-control', 'value'=>$range, 'min'=>0]) !!}
</div>

<!-- Date Of Opening Field -->
<div class="form-group col-sm-4">
    {!! Form::label('date_of_opening', 'Date Of Opening*:') !!}
    {!! Form::date('date_of_opening',null, ['class' => 'form-control', 'required'=>'true', 'value'=>$date_of_opening]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
</div>
{!! Form::close() !!}